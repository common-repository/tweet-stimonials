<?php /***
Forms
(SPYR) Admin Library

SPYRmedia.com
*/



/*** Forms */

class SPYR_Admin_Forms {
	
	public $options;
	
	function __construct() {
		$this->options = array();
		}


	/*** Textbox *
	
	== Usage ==
	echo $spyr_forms->get_textbox(array(
		'type' => 'text',
		'label' => 'Textbox',
		'value' => 'Default Value',
		'input_name' => 'spyrforms_textbox',
		'class' => 'regular-text',
		'tabIndex' => ++$tabIndex,
		'add_margin' => false)
		);
	*/
	function get_textbox($input) {
		$input['type'] = ($input['type'] == 'textbox' ? 'text' : $input['type']);
		$to_return = '
			<div class="spyr_textbox' . ($input['type'] == 'password' ? ' spyr_password' : ($input['type'] == 'email' ? ' spyr_email' : '')) . ($input['add_margin'] ? ' add_margin' : '') . (isset($input['wrap_class']) ? ' ' . $input['wrap_class'] : '') . '">
				<label class="spyr_small" for="' . $input['input_name'] . '">' . $input['label'] . '</label>
				<input type="' . $input['type'] . '" name="' . $input['input_name'] . '" id="' . $input['input_name'] . '" value="' . ($input['type'] != 'password' ? $input['value'] : '' ) . '" tabindex="' . $input['tabIndex'] . '" class="' . $input['class'] . '" />
				</div>';
		return $to_return;
		}
	
	
	
	/*** Textarea *
	
	== Usage ==
	echo $spyr_forms->get_textarea(array(
		'label' => 'Textbox',
		'value' => 'Default Value',
		'input_name' => 'spyrforms_textarea',
		'class' => 'regular-text',
		'tabIndex' => ++$tabIndex,
		'rows' => '3',
		'cols' => '20',
		'add_margin' => false)
		);
	*/
	function get_textarea($input) {
		$to_return = '
			<div class="spyr_textarea' . ($input['add_margin'] ? ' add_margin' : '') . '">
				<label class="spyr_small" for="' . $input['input_name'] . '">' . $input['label'] . '</label>
				<textarea name="' . $input['input_name'] . '" id="' . $input['input_name'] . '" tabindex="' . $input['tabIndex'] . '" class="' . $input['class'] . '" rows="' . (isset($input['rows']) ? $input['rows'] : '3') . '" cols="' . (isset($input['cols']) ? $input['cols'] : '20') . '">' . $input['value'] . '</textarea>
				</div>';
		return $to_return;
		}
	
	
	
	/*** Checkboxes *
	
	== Usage ==
	echo $spyr_forms->get_checkboxes(array(
		'checkboxes' => array(
			array('label' => 'Checkbox #1','name' => 'value1','class' => 'square','checked' => true),
			array('label' => 'Checkbox #2','name' => 'value2','class' => 'square','checked' => true),
			array('label' => 'Checkbox #3','name' => 'value3','class' => 'square','checked' => false)
			),
		'input_name' => 'spyrforms_checkbox2',
		'tabIndex' => ++$tabIndex,
		'add_margin' => true)
		);
	*/
	function get_checkboxes($inputs) {
		$tabIndex = $inputs['tabIndex'];
		$to_return = '
			<div class="spyr_checkboxes' . ($inputs['add_margin'] ? ' add_margin' : '') . '" id="' . $inputs['input_name'] . '">';
		foreach ($inputs['checkboxes'] as $checkbox) {
			$to_return .= '
				<label class="spyr_button' . (!empty($checkbox['class']) ? ' ' . $checkbox['class'] : '') . ($checkbox['checked'] ? ' checked' : '' ) . '" for="' . $inputs['input_name'] . '_' . $checkbox['name'] . '">' . $checkbox['label'] . '</label>
					<input type="checkbox" class="spyr_button_input" name="' . $inputs['input_name'] . '[' . $checkbox['name'] . ']" id="' . $inputs['input_name'] . '_' . $checkbox['name'] . '" value="1" tabindex="' . $tabIndex . '"' . checked($checkbox['checked'],true,false) . ' />';
				$tabIndex++;
			}
		$to_return .= '
				</div>';
		return $to_return;
		}
	
	
	/*** Radios *
	
	== Usage ==
	echo $spyr_forms->get_radios(array(
		'radios' => array(
			array('label' => 'Radio #1','value' => '01','class' => 'circle'),
			array('label' => 'Radio #2','value' => '02','class' => 'circle'),
			array('label' => 'Radio #3','value' => '03','class' => 'circle')
			),
		'label' => '',
		'input_name' => 'spyrforms_radio',
		'selected_value' => '01',
		'tabIndex' => ++$tabIndex,
		'add_margin' => true)
		);
	*/
	function get_radios($inputs) {
		$input_count = 1;
		$tabIndex = $inputs['tabIndex'];
		$to_return = '
			' . (isset($inputs['label']) ? '<label class="spyr_small">' . $inputs['label'] . '</label>' : '') . '
			<div class="spyr_radios' . ($inputs['add_margin'] ? ' add_margin' : '') . (isset($inputs['class']) ? ' ' . $inputs['class'] : '') . '" id="' . $inputs['input_name'] . '">';
		foreach ($inputs['radios'] as $radio) {
			$to_return .= '
				<label class="spyr_button' . (!empty($radio['class']) ? ' ' . $radio['class'] : '') . ($radio['value'] == $inputs['selected_value'] ? ' checked' : '') . '" for="' . $inputs['input_name'] . '_' . $input_count . '">' . $radio['label'] . '</label>
					<input type="radio" class="spyr_button_input" name="' . $inputs['input_name'] . '" id="' . $inputs['input_name'] . '_' . $input_count . '" value="' . ($radio['value'] ? $radio['value'] : '1') . '" tabindex="' . $tabIndex . '"' . checked($radio['value'],$inputs['selected_value'],false) . ' />';
				$tabIndex++;
				$input_count++;
			}
		$to_return .= '
				</div>';
		return $to_return;
		}
	
	
	/*** Note *
	
	== Usage ==
	echo $spyr_forms->get_note(__('<p>This is the note body</p>','spyr'));
	*/
	function get_note($text,$add_margin = false) {
		return '
			<div class="spyr_note' . ($add_margin ? ' add_margin' : '') . '">
				' . $text . '
				</div>';
		}
	
	}

/* END Forms ***/





