<?php

namespace App\Models;

class About extends AppModel
{
	const IMAGE_DESTINATION_PATH = 'uploads/images/about';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'about_us';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'header_title',
		'header_content',
		'header_image',
		'section_1_title',
		'section_1_content',
		'section_2_title',
		'section_2_content',
		'section_2_image',
		'section_2_button_display',
		'section_2_button_title',
		'section_2_button_url',
		'section_3_title',
		'section_3_content',
		'section_3_image',
		'section_3_button_display',
		'section_3_button_title',
		'section_3_button_url',
		'section_4_title',
		'section_4_video'
	];

	/**
	 * The attributes that are nullable by default.
	 *
	 * @var array
	 */
	protected $nullable = [
		'header_title',
		'header_content',
		'header_image',
		'section_1_title',
		'section_1_content',
		'section_2_title',
		'section_2_content',
		'section_2_image',
		'section_2_button_display',
		'section_2_button_title',
		'section_2_button_url',
		'section_3_title',
		'section_3_content',
		'section_3_image',
		'section_3_button_display',
		'section_3_button_title',
		'section_3_button_url',
		'section_4_title',
		'section_4_video'
	];

	/**
	 * Set model validation rules.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'header_title' => 'required',
			'header_content' => 'required',
			'header_image' => '',
			'section_1_title' => 'required',
			'section_1_content' => 'required',
			'section_2_title' => 'required',
			'section_2_content' => 'required',
			'section_2_image' => '',
			'section_2_button_display' => 'required|boolean',
			'section_2_button_title' => 'required',
			'section_2_button_url' => 'required',
			'section_3_title' => 'required',
			'section_3_content' => 'required',
			'section_3_image' => '',
			'section_3_button_display' => 'required|boolean',
			'section_3_button_title' => 'required',
			'section_3_button_url' => 'required',
			'section_4_title' => 'required',
			'section_4_video' => 'required',
		];
	}
}
