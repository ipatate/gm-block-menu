import { registerBlockType } from "@wordpress/blocks";
import { withSelect } from "@wordpress/data";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import { useBlockProps, withColors } from "@wordpress/block-editor";
import Panel from "./Panel";

registerBlockType("goodmotion/block-menu", {
	title: __("GM Block Menu", "gm-block-menu"),
	description: __("Block for display menu.", "gm-block-menu"),
	icon: "buddicons-community",
	category: "goodmotion-blocks",
	example: {},
	attributes: {
		categories: {
			type: "array",
			default: [],
		},
		blocTitle: {
			type: "string",
			default: "La carte",
		},
		textColor: {
			type: "string",
		},
		backgroundColor: {
			type: "string",
		},
		isAdmin: {
			type: "boolean",
			default: false,
		},
	},
	edit: withColors({ textColor: "color", backgroundColor: "background-color" })(
		withSelect((select) => {
			return {
				// menus categories list
				menus_categories: select("core").getEntityRecords(
					"taxonomy",
					"menus_categories",
					{ per_page: 100 }
				),
			};
		})((props) => {
			const { textColor, backgroundColor } = props;
			const blockProps = useBlockProps();
			return (
				<div {...useBlockProps()}>
					<Panel props={props} />
					<ServerSideRender
						block="goodmotion/block-menu"
						attributes={{ ...props.attributes, isAdmin: true }}
					/>
				</div>
			);
		})
	),
	// save
});
