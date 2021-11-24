import { registerBlockType } from "@wordpress/blocks";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

registerBlockType("goodmotion/block-actu", {
	title: __("GM Block Actu", "gm-block-actu"),
	description: __("Block for display actu.", "gm-block-actu"),
	icon: "buddicons-community",
	category: "energeo-blocks",
	example: {},
	attributes: {},
	edit: (props) => {
		const blockProps = useBlockProps();
		return (
			<div {...useBlockProps()}>
				<ServerSideRender
					block="goodmotion/block-actu"
					attributes={{ ...props.attributes }}
				/>
			</div>
		);
	},
	// save
});
