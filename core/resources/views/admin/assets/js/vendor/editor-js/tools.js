import List from "@editorjs/list";
import Header from "@editorjs/header";
import Marker from "@editorjs/marker";
import LinkTool from "@editorjs/link";
import Embed from "@editorjs/embed";
import AttachesTool from "@editorjs/attaches";
import Paragraph from "@editorjs/paragraph";
import Table from "@editorjs/table";
import ImageTool from "@editorjs/image";
import RawTool from "@editorjs/raw";
import Gallery from "./gallery";

const Tools = {
    header: Header,
    paragraph: {
        class: Paragraph,
        inlineToolbar: true
    },
    embed: {
        class: Embed,
        inlineToolbar: true,
        config: {
            services: {
                youtube: true,
                instagram: true,
                vimeo: true,
                twitter: true,
                soundcloud: {
                    regex: /(https?:\/\/soundcloud.com\/(.*)\/(.*))/,
                    embedUrl:
                        "https://w.soundcloud.com/player/?url=<%= remote_id %>&color=%23ff5500&auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&show_teaser=false",
                    html:
                        "<iframe width='100%' height='166' scrolling='no' frameborder='no' allow='autoplay'></iframe>",
                    height: 166,
                    width: 600
                },
                spotify: {
                    regex: /.*spotify.com\/show\/([A-z0-9]+).*/,
                    embedUrl:
                        "https://open.spotify.com/embed/show/<%= remote_id %>",
                    html:
                        "<iframe width='100%' height='166' scrolling='no' frameborder='no' allow='encrypted-media'></iframe>",
                    height: 166,
                    width: 600
                },
                pinterest: {
                    regex: /https?:\/\/([^\/\?\&]*).pinterest.com\/pin\/([^\/\?\&]*)\/?$/,
                    embedUrl:
                        "https://assets.pinterest.com/ext/embed.html?id=<%= remote_id %>",
                    html:
                        "<iframe scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%; min-height: 400px; max-height: 1000px;'></iframe>",
                    id: ids => {
                        return ids[1];
                    }
                },
                facebook: {
                    regex: /https?:\/\/www.facebook.com\/([^\/\?\&]*)\/(.*)/,
                    embedUrl:
                        "https://www.facebook.com/plugins/post.php?href=https://www.facebook.com/<%= remote_id %>&width=500",
                    html:
                        "<iframe scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%; min-height: 500px; max-height: 1000px;'></iframe>",
                    id: ids => {
                        return ids.join("/");
                    }
                }
            }
        }
    },
    list: {
        class: List,
        inlineToolbar: true
    },
    Marker: Marker,
    table: {
        class: Table
    },
    gallery: {
        class: Gallery,
        config: {
            endpoints: {
                byFile: "/support/storeimage?destination=editorjs"
            },
            buttonContent:
                '<span class="ti-image"></span> Selecione uma imagem',
            additionalRequestHeaders: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        }
    },
    image: {
        class: ImageTool,
        config: {
            endpoints: {
                byFile: "/support/storeimage?destination=editorjs", // Your backend file uploader endpoint
                byUrl: "/support/storeimage?destination=editorjs" // Your endpoint that provides uploading by Url
            },
            captionPlaceholder: "Legenda",
            buttonContent:
                '<span class="ti-image"></span> Selecione uma imagem',
            additionalRequestHeaders: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        }
    },
    attaches: {
        class: AttachesTool,
        config: {
            endpoint: "/support/storefile?destination=editorjs",
            buttonText: "Selecione um arquivo",
            errorMessage: "O upload do arquivo falhou",
            additionalRequestHeaders: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        }
    },
    /* linkTool: {
        class: LinkTool,
        config: {
            endpoint: "/support/oembed"
        }
    }, */
    raw: RawTool
};

export default {
    all: { ...Tools },
    basic: {
        header: Tools.header,
        paragraph: Tools.paragraph,
        list: Tools.list,
        Marker: Tools.Marker,
        table: Tools.table,
        raw: Tools.raw
    }
};
