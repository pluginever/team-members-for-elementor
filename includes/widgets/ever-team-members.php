<?php

namespace Pluginever\TME\Widget;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Widget_Base;

class Team_Members extends Widget_Base {
    public function get_name() {
        return 'ever-team-members';
    }

    public function get_title() {
        return 'Team Members';
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'ever-elements' ];    // category of the widget
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Banner', 'ultimate-elementor' ),
            ]
        );

        $this->add_control(
            'member_photo',
            [
                'label' => __( 'Photo', 'your-plugin' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'member_name',
            [
                'label'       => __( 'Name', 'your-plugin' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Member Name', 'your-plugin' ),
                'placeholder' => __( 'Type name of the team member', 'your-plugin' ),
            ]
        );

        $this->add_control(
            'member_title',
            [
                'label'       => __( 'Title', 'your-plugin' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Member Title', 'your-plugin' ),
                'placeholder' => __( 'Type title of the team member', 'your-plugin' ),
            ]
        );

        $this->add_control(
            'member_socials',
            [
                'label' => __( 'Social Links', 'plugin-domain' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'social_icon',
                        'label' => __( 'Social Icon', 'plugin-domain' ),
                        'type' => Controls_Manager::ICON,
                        'include' => [
                            'fa fa-facebook',
                            'fa fa-flickr',
                            'fa fa-google-plus',
                            'fa fa-instagram',
                            'fa fa-linkedin',
                            'fa fa-pinterest',
                            'fa fa-reddit',
                            'fa fa-twitch',
                            'fa fa-twitter',
                            'fa fa-vimeo',
                            'fa fa-youtube',
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'member_social_link',
                        'label' => __( 'Social Link', 'plugin-domain' ),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => 'http://',
                            'is_external' => '',
                        ],
                        'show_label' => false,
                    ],
                ],
                'title_field' => '{{{ social_icon }}}',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $socials = $settings['member_socials'];
        ?>

        <div class="ever-elements ee-team-members">
            <div class="ee-team-members-container">
                <div class="ee-team-members-overlay"></div>
                <img src="<?php echo esc_url_raw($settings['member_photo']['url']);?>" alt="">
                <div class="ee-team-members-socials">
                    <?php if( !empty($socials)){
                        foreach ($socials as $social){
                            echo "<a href='{$social['member_social_link']['url']}' target='_blank'><i class='{$social['social_icon']}' aria-hidden='true'></i></a>";
                        }

                    } ?>
                </div>
            </div>
            <div class="ee-team-members-bottom-container">
                <h2><?php echo esc_html($settings['member_name']);?></h2>
                <h3><?php echo esc_html($settings['member_title']);?></h3>
            </div>
        </div>


        <?php
    }

    protected function _content_template() {
        ?>
        <#
        console.log(settings);
        console.log(settings);
        #>
        <div class="ever-elements ee-team-members">
            <div class="ee-team-members-container">
                <div class="ee-team-members-overlay"></div>
                <img src="{{settings.member_photo.url}}" alt="">
                <# if ( settings.member_socials ) { #>

                    <# _.each( settings.list, function( item ) { #>
                            <a href='{{item.member_social_link.url}}' target='_blank'><i class='{{item.member_social_link.social_icon}}' aria-hidden='true'></i></a>
                    <# }); #>

                <# } #>
                </div>
            </div>
            <div class="ee-team-members-bottom-container">
                <h2>{{settings.member_name}}</h2>
                <h3>{{settings.member_title}}</h3>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Team_Members() );
