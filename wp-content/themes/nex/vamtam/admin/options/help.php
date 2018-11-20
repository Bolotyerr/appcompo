<?php
return array(
	'name' => esc_html__( 'Help', 'nex' ),
	'auto' => true,
	'config' => array(

		array(
			'name' => esc_html__( 'Help', 'nex' ),
			'type' => 'title',
			'desc' => '',
		),

		array(
			'name' => esc_html__( 'Help', 'nex' ),
			'type' => 'start',
			'nosave' => true,
		),
//----
		array(
			'type' => 'docs',
		),

			array(
				'type' => 'end',
			),
	),
);
