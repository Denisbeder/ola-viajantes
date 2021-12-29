import EditorJS from "@editorjs/editorjs";
import DragDrop from "editorjs-drag-drop";
//import Undo from "editorjs-undo";
import Undo from "./undo";
import tools from "./tools";

const elementEditor = $("#editor, #editor-basic");
if (elementEditor.length > 0) {
    const elementInput = $(elementEditor.attr("data-input"));
    const dataBlocks =
        elementInput.val().length > 0 ? JSON.parse(elementInput.val()) : null;
    const elementButton = $("[type='submit']");

    elementButton.on("click", function(e) {
        e.preventDefault();
        elementButton.attr("disabled", true);
        const $this = $(this);
        const form = $this.closest("form");

        if ($this.attr("name") === "submit_continue") {
            form.prepend($("<input>").attr("type", "hidden").attr("name", "submit_continue").attr("value", "1"));
        }

        if ($this.attr("name") === "draft") {
            form.prepend($("<input>").attr("type", "hidden").attr("name", "draft").attr("value", "1"));
        }

        editor
            .save()
            .then(outputData => {
                if (outputData.blocks.length) {
                    elementInput.val(JSON.stringify(outputData));
                } else {
                    elementInput.val(""); 
                }              
            })
            .catch(error => {
                console.log("Saving failed: ", error);
            })
            .finally(() => {
                form.submit();
            });
    });

    const editor = new EditorJS({
        onReady: () => {
            const undo = new Undo({ editor });
            if (dataBlocks !== null) {
                undo.initialize(dataBlocks);  
            } else {                
                undo.initialize({blocks: []});  
            }
  
            new DragDrop(editor);
        },
        holder: elementEditor.attr("id"),
        logLevel: "ERROR",
        placeholder: "Digite ou cole seu texto aqui...",
        minHeight: 60,
        data: dataBlocks, // {blocks:[]}
        tools: !elementEditor.attr("id").includes("basic")
            ? tools.all
            : tools.basic
    });
}
