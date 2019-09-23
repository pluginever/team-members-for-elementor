<?php

namespace Pluginever\TME\Widget;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Team_Members extends Widget_Base {
    public function get_name() {
        return 'ever-team-members';
    }

    public function get_title() {
        return __( 'Team Members', 'ever_team_members' );
    }

    public function get_icon() {
        return 'fa fa-group';
    }

//    public function get_categories() {
//        return [ 'general-elements' ];    // category of the widget
//    }

    protected function _register_controls() {
        $this->start_controls_section(
            'member_image',
            [
                'label' => __( 'Member Image', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        /**
         * Image
         */
        $this->add_control(
            'member_photo',
            [
                'label'   => __( 'Image', 'ever_team_members' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'large',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        /**
         * Information
         */
        $this->start_controls_section(
            'member_info',
            [
                'label' => __( 'Member Information', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'member_name',
            [
                'label'       => __( 'Name', 'ever_team_members' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'John Doe', 'ever_team_members' ),
                'placeholder' => __( 'Type name of the team member', 'ever_team_members' ),
            ]
        );

        $this->add_control(
            'member_title',
            [
                'label'       => __( 'Title', 'ever_team_members' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'CEO', 'ever_team_members' ),
                'placeholder' => __( 'Type title of the team member', 'ever_team_members' ),
            ]
        );

        $this->add_control(
            'member_bio',
            [
                'label'       => __( 'Short Bio', 'ever_team_members' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Write some description about the member. Remove the text if you don\'t want to.', 'ever_team_members' ),
                'placeholder' => __( 'Write some description about the member', 'ever_team_members' ),
            ]
        );

        $this->end_controls_section();

        /**
         * Social Profiles
         */

        $this->start_controls_section(
            'social_profiles',
            [
                'label' => __( 'Social Profiles', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_social_profiles',
            [
                'label'   => esc_html__( 'Display Social Profiles?', 'ever_team_members' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'social_profile_links',
            [
                'type'        => Controls_Manager::REPEATER,
                'condition'   => [
                    'enable_social_profiles!' => '',
                ],
                'default'     => [
                    [
                        'social_new' => [
                            'value'   => 'fab fa-facebook',
                            'library' => 'fa-brands'
                        ]
                    ],
                    [
                        'social_new' => [
                            'value'   => 'fab fa-twitter',
                            'library' => 'fa-brands'
                        ]
                    ],
                    [
                        'social_new' => [
                            'value'   => 'fab fa-linkedin',
                            'library' => 'fa-brands'
                        ]
                    ],
                ],
                'fields'      => [
                    [
                        'name'             => 'social_new',
                        'label'            => esc_html__( 'Icon', 'ever_team_members' ),
                        'type'             => Controls_Manager::ICONS,
                        'fa4compatibility' => 'social',
                        'default'          => [
                            'value'   => 'fab fa-wordpress',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'name'        => 'link',
                        'label'       => esc_html__( 'Link', 'ever_team_members' ),
                        'type'        => Controls_Manager::URL,
                        'label_block' => true,
                        'default'     => [
                            'url'         => '',
                            'is_external' => 'true',
                        ],
                        'placeholder' => esc_html__( 'Enter the URL', 'ever_team_members' ),
                    ],
                ],
                'title_field' => '{{{ social_new.value.replace(/(far )?(fab )?(fa )?(fa\-)/gi, \'\').replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}} <i class="{{ social_new.value }}" style="float: right;"></i>',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         */

        //Image Styles
        $this->start_controls_section(
            'image_styles',
            [
                'label' => esc_html__( 'Image Styles', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'image_rounded',
            [
                'label'        => esc_html__( 'Rounded Avatar?', 'ever_team_members' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'team-avatar-rounded',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__( 'Image Width', 'ever_team_members' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => [ '%', 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item figure img' => 'width:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __( 'Height', 'happy-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 700,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ha-member-figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__( 'Margin', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__( 'Padding', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control( 'border_heading', [
            'type'      => Controls_Manager::HEADING,
            'label'     => __( 'Border', 'ever-addons-for-elementor' ),
            'separator' => 'before',
        ] );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__( 'Border', 'ever_team_members' ),
                'selector' => '{{WRAPPER}} .eael-team-item figure img',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'ever_team_members' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eael-team-item figure img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                    'image_rounded!' => 'team-avatar-rounded',
                ],
            ]
        );

        $this->end_controls_section();

        //Information Styles
        $this->start_controls_section(
            'info_styles',
            [
                'label' => esc_html__( 'Information Styles', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'name_heading',
            [
                'label'     => __( 'Member Name', 'ever_team_members' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => esc_html__( 'Name Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#272727',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-item .eael-team-member-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .eael-team-item .eael-team-member-name',
            ]
        );

        $this->add_control(
            'position_heading',
            [
                'label' => __( 'Member Title', 'ever_team_members' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label'     => esc_html__( 'Title Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#272727',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-item .eael-team-member-position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .eael-team-item .eael-team-member-position',
            ]
        );

        $this->add_control(
            'bio_heading',
            [
                'label' => __( 'Member Bio', 'ever_team_members' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bio_color',
            [
                'label'     => esc_html__( 'Bio Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#272727',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-item .eael-team-content .eael-team-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'bio_typography',
                'selector' => '{{WRAPPER}} .eael-team-item .eael-team-content .eael-team-text',
            ]
        );

        $this->end_controls_section();

        //Social Profiles Styles
        $this->start_controls_section(
            'profile_styles',
            [
                'label' => esc_html__( 'Social Profiles Styles', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'social_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'ever_team_members' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'profiles_margin',
            [
                'label' => esc_html__( 'Social Profiles Margin', 'ever_team_members' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .eael-team-content > .eael-team-member-social-profiles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_padding',
            [
                'label'      => esc_html__( 'Icon Padding', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-content > .eael-team-member-social-profiles li.eael-team-member-social-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'ever_team_members' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs( 'social_icons_style_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'ever_team_members' ) ] );

        $this->add_control(
            'social_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'ever_team_members' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1ba63',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_background',
            [
                'label' => esc_html__( 'Background Color', 'ever_team_members' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'social_icon_border',
                'selector' => '{{WRAPPER}} .eael-team-member-social-link > a',
            ]
        );

        $this->add_control(
            'social_icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ever_team_members' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'social_icon_hover', [ 'label' => esc_html__( 'Hover', 'ever_team_members' ) ] );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'ever_team_members' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ad8647',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_background',
            [
                'label' => esc_html__( 'Hover Background Color', 'ever_team_members' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_border_color',
            [
                'label' => esc_html__( 'Hover Border Color', 'ever_team_members' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-team-member-social-link > a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
       // $settings = $this->get_settings();
        $settings = $this->get_settings_for_display();
        $socials  = $settings['member_socials'];

        $this->add_inline_editing_attributes( 'member_title', 'none' );
        $this->add_render_attribute( 'member_title', 'class', '' );

        $this->add_inline_editing_attributes( 'member_title', 'none' );
        $this->add_render_attribute( 'member_title', 'class', '' );

        $this->add_inline_editing_attributes( 'member_bio', 'basic' );
        $this->add_render_attribute( 'member_bio', 'class', '' );


        ?>

        <div class="ever-elements ee-team-members">
            <div class="ee-team-members-container">
                <div class="ee-team-members-overlay"></div>
                <img src="<?php echo esc_url_raw( $settings['member_photo']['url'] ); ?>" alt="">
                <div class="ee-team-members-socials">
                    <?php if ( ! empty( $socials ) ) {
                        foreach ( $socials as $social ) {
                            if ( ! empty( $social['member_social_link']['url'] ) && ! empty( $social['social_icon'] ) ) {
                                echo "<a href='{$social['member_social_link']['url']}' target='_blank'><i class='{$social['social_icon']}' aria-hidden='true'></i></a>";
                            }
                        }

                    } ?>
                </div>
            </div>
            <div class="ee-team-members-bottom-container">
                <h2><?php echo esc_html( $settings['member_name'] ); ?></h2>
                <h3><?php echo esc_html( $settings['member_title'] ); ?></h3>
            </div>
        </div>


        <?php
    }

    protected function _content_template() {
        ?>
        <div class="ever-elements ee-team-members">
            <div class="ee-team-members-container">
                <div class="ee-team-members-overlay"></div>
                <img src="{{settings.member_photo.url}}" alt=""> <# if ( settings.member_socials ) { #>

                <# _.each( settings.list, function( item ) { #> <# if( item.member_social_link.url ) { #>
                <a href='{{item.member_social_link.url}}' target='_blank'><i class='{{item.member_social_link.social_icon}}' aria-hidden='true'></i></a> <# } #> <# }); #>

                <# } #>
            </div>
        </div>
        <div class="ee-team-members-bottom-container">
            <h2>{{settings.member_name}}</h2>
            <h3>{{settings.member_title}}</h3>
        </div></div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Team_Members() );
