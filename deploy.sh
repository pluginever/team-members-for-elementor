#! /bin/bash
# Exit if any command fails.
set -e

# Enable nicer messaging for build status.
BLUE_BOLD='\033[1;34m';
GREEN_BOLD='\033[1;32m';
RED_BOLD='\033[1;31m';
YELLOW_BOLD='\033[1;33m';
COLOR_RESET='\033[0m';
error () {
	echo -e "\n${RED_BOLD}$1${COLOR_RESET}"
}
status () {
	echo -e "\n${BLUE_BOLD}$1${COLOR_RESET}"
}
success () {
	echo -e "\n${GREEN_BOLD}$1${COLOR_RESET}"
}
warning () {
	echo -e "\n${YELLOW_BOLD}$1${COLOR_RESET}"
}

status "💃 Time to release plugin 🕺"

# Set up some default values. Feel free to change these in your own script
CURRENTDIR=$(pwd)
PLUGINSLUG="team-members-for-elementor"
SVNUSER="manikmist09"
SVNPATH="/tmp/$PLUGINSLUG"
SVNURL="https://plugins.svn.wordpress.org/$PLUGINSLUG"
PLUGINDIR="$CURRENTDIR"
MAINFILE="$PLUGINSLUG.php"
ASSETSDIR=".wordpress-org"


# Check directory exists.
if [ ! -d "$PLUGINDIR" ]; then
	error "Directory $PLUGINDIR not found. Aborting."
	exit 1
fi

# Check if SVN assets directory exists.
if [ ! -d "$PLUGINDIR/$ASSETSDIR" ]; then
	status "SVN assets directory $PLUGINDIR/$ASSETSDIR not found."
	warning "This is not fatal but you may not have intended results."
fi

# Check main plugin file exists.
if [ ! -f "$PLUGINDIR/$MAINFILE" ]; then
	error "Plugin file $PLUGINDIR/$MAINFILE.php not found. Aborting."
	exit 1
fi

# Check version in readme.txt is the same as plugin file after translating both to Unix line breaks to work around grep's failure to identify Mac line breaks
PLUGINVERSION=$(grep -i "Version:" $PLUGINDIR/$MAINFILE | awk -F' ' '{print $NF}' | tr -d '\r')
status "$MAINFILE version: $PLUGINVERSION"
READMEVERSION=$(grep -i "Stable tag:" $PLUGINDIR/readme.txt | awk -F' ' '{print $NF}' | tr -d '\r')
status "readme.txt version: $READMEVERSION"

if [ "$READMEVERSION" = "trunk" ]; then
	status "Version in readme.txt & $MAINFILE don't match, but Stable tag is trunk. Let's continue..."
elif [ "$PLUGINVERSION" != "$READMEVERSION" ]; then
	error "Version in readme.txt & $MAINFILE don't match. Exiting...."
	exit 1
elif [ "$PLUGINVERSION" = "$READMEVERSION" ]; then
	warning "Versions match in readme.txt and $MAINFILE. Let's continue..."
fi

success "That's all of the data collected."
success
success "Slug: $PLUGINSLUG"
success "Plugin directory: $PLUGINDIR"
success "Main file: $MAINFILE"
success "Temp checkout path: $SVNPATH"
success "Remote SVN repo: $SVNURL"
success "SVN username: $SVNUSER"


printf "OK to proceed (Y|n)? "
read -e input
PROCEED="${input:-y}"
echo

# Allow user cancellation
if [ $(echo "$PROCEED" | tr [:upper:] [:lower:]) != "y" ]; then
	error "Aborting..."
	exit 1
fi
status "Lets begin...."

status "Changing to $PLUGINDIR"
status $PLUGINDIR

# Check for git tag (may need to allow for leading "v"?)
# if git show-ref --tags --quiet --verify -- "refs/tags/$PLUGINVERSION"
if git show-ref --tags --quiet --verify -- "refs/tags/v$PLUGINVERSION"; then
	status "Git tag $PLUGINVERSION does exist. Let's continue..."
else
	status "$PLUGINVERSION does not exist as a git tag. Aborting."
	exit 1
fi

status "Creating local copy of SVN repo trunk..."
svn checkout $SVNURL $SVNPATH --depth immediates
svn update --quiet $SVNPATH/trunk --set-depth infinity
svn update --quiet $SVNPATH/tags/$PLUGINVERSION --set-depth infinity

status "Ignoring GitHub specific files"
# Use local .svnignore if present
if [ -f ".svnignore" ]; then
	status "Using local .svnignore"
	SVNIGNORE=$(<.svnignore)
else
	status "Using default .svnignore"
	SVNIGNORE="README.md
Thumbs.db
.github
.git
.gitattributes
.gitignore
composer.lock"
fi

svn propset svn:ignore \""$SVNIGNORE"\" "$SVNPATH/trunk/"

status "Exporting the HEAD of master from git to the trunk of SVN"
git checkout-index -a -f --prefix=$SVNPATH/trunk/

# If submodule exist, recursively check out their indexes
if [ -f ".gitmodules" ]; then
	status "Exporting the HEAD of each submodule from git to the trunk of SVN"
	git submodule init
	git submodule update
	git config -f .gitmodules --get-regexp '^submodule\..*\.path$' |
		while read path_key path; do
			#url_key=$(status $path_key | sed 's/\.path/.url/')
			#url=$(git config -f .gitmodules --get "$url_key")
			#git submodule add $url $path
			status "This is the submodule path: $path"
			status "The following line is the command to checkout the submodule."
			status "git submodule foreach --recursive 'git checkout-index -a -f --prefix=$SVNPATH/trunk/$path/'"
			git submodule foreach --recursive 'git checkout-index -a -f --prefix=$SVNPATH/trunk/$path/'
		done
fi

# Support for the /assets folder on the .org repo, locally this will be /.wordpress-org
status "Moving assets."
# Make the directory if it doesn't already exist
mkdir -p $SVNPATH/assets/
mv $SVNPATH/trunk/.wordpress-org/* $SVNPATH/assets/
svn add --force $SVNPATH/assets/

status "Changing directory to SVN and committing to trunk."
cd $SVNPATH/trunk/
# Delete all files that should not now be added.
# Use $SVNIGNORE for `rm -rf`. Setting propset svn:ignore seems flaky.
status "$SVNIGNORE" | awk '{print $0}' | xargs rm -rf
svn status | grep -v "^.[ \t]*\..*" | grep "^\!" | awk '{print $2"@"}' | xargs svn del
# Add all new files that are not set to be ignored
svn status | grep -v "^.[ \t]*\..*" | grep "^?" | awk '{print $2"@"}' | xargs svn add
svn commit --username=$SVNUSER -m "Preparing for $PLUGINVERSION release"

status "Updating WordPress plugin repo assets and committing."
cd $SVNPATH/assets/
# Delete all new files that are not set to be ignored
svn status | grep -v "^.[ \t]*\..*" | grep "^\!" | awk '{print $2"@"}' | xargs svn del
# Add all new files that are not set to be ignored
svn status | grep -v "^.[ \t]*\..*" | grep "^?" | awk '{print $2"@"}' | xargs svn add
svn update --quiet --accept working $SVNPATH/assets/*
svn resolve --accept working $SVNPATH/assets/*
svn commit --username=$SVNUSER -m "Updating assets"

status "Removing temporary directory $SVNPATH."
cd $SVNPATH
cd ..
rm -fr $SVNPATH/

success "*** FIN ***"