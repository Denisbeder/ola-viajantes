import * as Trix from "trix";
import "trix/dist/trix.css";
import "./trix-attachment-gallery.scss";
import "./trix.scss";
import "./attach-file";

Trix.config.attachments.preview.caption = { name: false, size: false };
Trix.config.lang = {
    GB: "GB",
    KB: "KB",
    MB: "MB",
    PB: "PB",
    TB: "TB",
    attachFiles: "Anexar Arquivos",
    bold: "Negrito",
    bullets: "Lista",
    byte: "Byte",
    bytes: "Bytes",
    captionPlaceholder: "Add legenda…",
    code: "Código",
    heading1: "Título",
    indent: "Aumentar Recuo",
    italic: "Itálico",
    link: "Link",
    numbers: "Numeração",
    outdent: "Diminuir Recuo",
    quote: "Citação",
    redo: "Refazer",
    remove: "Remover",
    strike: "Strikethrough",
    undo: "Desfazer",
    unlink: "Remover Link",
    url: "URL",
    urlPlaceholder: "Digite uma URL…"
};