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

        $this->add_responsive_control(
            'align',
            [
                'label'     => __( 'Alignment', 'ever_team_members' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __( 'Left', 'ever_team_members' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __( 'Center', 'ever_team_members' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __( 'Right', 'ever_team_members' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'ever_team_members' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Social Profiles
         */

        $this->start_controls_section(
            'section_member_socials',
            [
                'label' => __( 'Social Profiles', 'ever_team_members' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_member_socials',
            [
                'label'   => esc_html__( 'Display Social Profiles?', 'ever_team_members' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'member_socials',
            [
                'type'        => Controls_Manager::REPEATER,
                'condition'   => [
                    'enable_member_socials!' => '',
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
                'return_value' => 'image-rounded',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__( 'Image Width', 'ever_team_members' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-photo' => 'width:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __( 'Height', 'ever_team_members' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-photo' => 'height:{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__( 'Margin', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-photo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ee-team-members-photo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control( 'border_heading', [
            'type'      => Controls_Manager::HEADING,
            'label'     => __( 'Border', 'ever_team_members' ),
            'separator' => 'before',
        ] );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__( 'Border', 'ever_team_members' ),
                'selector' => '{{WRAPPER}} .ee-team-members-photo',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'ever_team_members' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-photo' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
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
                    '{{WRAPPER}} .ee-team-members-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .ee-team-members-name',
            ]
        );

        $this->add_control(
            'position_heading',
            [
                'label'     => __( 'Member Title', 'ever_team_members' ),
                'type'      => Controls_Manager::HEADING,
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
                    '{{WRAPPER}} .ee-team-members-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .ee-team-members-title',
            ]
        );

        $this->add_control(
            'bio_heading',
            [
                'label'     => __( 'Member Bio', 'ever_team_members' ),
                'type'      => Controls_Manager::HEADING,
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
                    '{{WRAPPER}} .ee-team-members-bio' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'bio_typography',
                'selector' => '{{WRAPPER}} .ee-team-members-bio',
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
                'label'      => esc_html__( 'Icon Size', 'ever_team_members' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-social  i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'profiles_margin',
            [
                'label'      => esc_html__( 'Social Profiles Margin', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'range'      => [
                    'px' => [
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-social > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_padding',
            [
                'label'      => esc_html__( 'Icon Padding', 'ever_team_members' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ee-team-members-social  i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'social_icons_style_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'ever_team_members' ) ] );

        $this->add_control(
            'social_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_background',
            [
                'label'     => esc_html__( 'Background Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'social_icon_border',
                'selector' => '{{WRAPPER}} .ee-team-members-social  i',
            ]
        );

        $this->add_control(
            'social_icon_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'ever_team_members' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'social_icon_hover', [ 'label' => esc_html__( 'Hover', 'ever_team_members' ) ] );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label'     => esc_html__( 'Icon Hover Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_background',
            [
                'label'     => esc_html__( 'Hover Background Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_border_color',
            [
                'label'     => esc_html__( 'Hover Border Color', 'ever_team_members' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ee-team-members-social  i:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $member_photo     = $this->get_settings( 'member_photo' );
        $member_photo_url = Group_Control_Image_Size::get_attachment_image_src( $member_photo['id'], 'thumbnail', $settings );
        $member_photo_url = empty( $member_photo_url ) ? $member_photo['url'] : $member_photo_url;

        $classes = implode( ' ', [
            $settings['image_rounded'],
        ] );

        $this->add_render_attribute( 'member_name', 'class', 'ee-team-members-name' );
        $this->add_render_attribute( 'member_title', 'class', 'ee-team-members-title' );
        $this->add_render_attribute( 'member_bio', 'class', 'ee-team-members-bio' );

        $this->add_render_attribute( 'member_photo', 'class', 'ee-team-members-photo' );
        $this->add_render_attribute( 'member_photo', 'src', esc_url( $member_photo_url ) );
        $this->add_render_attribute( 'member_photo', 'alt', esc_attr( get_post_meta( $member_photo['id'], '_wp_attachment_image_alt', true ) ) );


        ?>

        <div class="ever-elements ee-team-members <?php echo $classes; ?>">
            <div class="ee-team-members-container">
                <?php printf( '<img %1$s>', $this->get_render_attribute_string( 'member_photo' ) ); ?>
            </div>

            <div class="ee-team-members-bottom-container">
                <?php
                printf( '<h2 %1$s>%2$s</h2>', $this->get_render_attribute_string( 'member_name' ), $settings['member_name'] );
                printf( '<h3 %1$s>%2$s</h3>', $this->get_render_attribute_string( 'member_title' ), $settings['member_title'] );
                ?>

                <?php if ( ! empty( $settings['member_socials'] ) ) { ?>
                    <ul class="ee-team-members-socials">
                        <?php
                        foreach ( $settings['member_socials'] as $item ) {
                            printf( '<li class="ee-team-members-social"><a href="%1$s" %2$s><i class="%3$s"></i></a></li>',
                                esc_attr( $item['link']['url'] ),
                                $item['link']['is_external'] ? ' target="_blank"' : '',
                                esc_attr( $item['social_new']['value'] )
                            );
                        }
                        ?>
                    </ul>
                <?php } ?>

                <?php
                printf( '<p %1$s>%2$s</p>', $this->get_render_attribute_string( 'member_bio' ), $settings['member_bio'] );
                ?>

            </div>
        </div>


        <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Team_Members() );
