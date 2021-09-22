import {
	PanelBody,
	RangeControl,
	TextControl,
	SelectControl,
} from "@wordpress/components";
import { InspectorControls, PanelColorSettings } from "@wordpress/blockEditor";
import { __ } from "@wordpress/i18n";

const Panel = ({ props }) => {
	const {
		attributes,
		setAttributes,
		menus_categories,
		textColor,
		backgroundColor,
		setTextColor,
		setBackgroundColor,
	} = props;
	const { total, categories, blocTitle } = attributes;
	const options = menus_categories
		? menus_categories.map((e) => ({ label: e.name, value: e.id }))
		: [];
	return (
		<InspectorControls>
			<PanelBody title={__("Settings", "gm-block-menu")}>
				<TextControl
					label={__("Title", "gm-block-menu")}
					value={blocTitle}
					onChange={(content) => setAttributes({ blocTitle: content })}
				/>
				<SelectControl
					label={__("Category", "gm-block-menu")}
					value={categories}
					multiple
					options={options}
					onChange={(content) => setAttributes({ categories: content })}
				/>
				<PanelColorSettings
					title={__("Color settings")}
					colorSettings={[
						{
							value: backgroundColor.color,
							onChange: setBackgroundColor,
							label: __("Background color", "gm-wrapper-full-text"),
						},
						{
							value: textColor.color,
							onChange: setTextColor,
							label: __("Text color", "gm-wrapper-full-text"),
						},
					]}
				/>
			</PanelBody>
		</InspectorControls>
	);
};

export default Panel;
