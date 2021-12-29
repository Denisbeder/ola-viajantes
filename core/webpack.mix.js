const mix = require("laravel-mix");
require("laravel-mix-purgecss");
const purgePatterns = [
    /owl/,
    /active/,
    /progress/,
    /lg-/,
    /ce-/,
    /ti-/,
    /flatpickr-/,
    /mfp-/,
    /class/,
    /modal/,
    /tooltip/,
    /show/,
    /fade/,
    /facebook/,
    /youtube/,
    /instagram/,
    /twitter/,
    /pagination/,
    /page-/,
    /ui-/,
    /list-/
];
const purgeCssDefaultConfig = require("postcss-purgecss-laravel/src/defaultConfig");
const purgeCssConfig = Object.assign(purgeCssDefaultConfig, {
    whitelistPatterns: purgePatterns,
    whitelistPatternsChildren: purgePatterns
});

mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.ProvidePlugin({
                $: "jquery",
                jQuery: "jquery",
                jquery: "jquery",
                "window.jQuery": "jquery",
                Popper: ["popper.js", "default"],
                noUiSlider: "nouislider"
            })
        ],
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"]
        }
    };
});
mix.config.fileLoaderDirs.fonts = "assets/fonts";
mix.setPublicPath("../public/");

mix.copyDirectory(
    "resources/views/site/assets/svg",
    "../public/assets/site/svg"
)
    .copyDirectory(
        "resources/views/site/assets/img",
        "../public/assets/site/img"
    )
    .copyDirectory(
        "resources/views/admin/assets/img",
        "../public/assets/admin/img"
    )
    .copy(
        "resources/views/admin/assets/fonts/Montserrat-Black.ttf",
        "../public/assets/admin/fonts/Montserrat-Black.ttf"
    )
    .copyDirectory(
        "resources/views/errors/assets/img",
        "../public/assets/errors/img"
    );

mix.js("resources/views/site/assets/js/main.js", "assets/site/js")
    .js("resources/views/site/assets/js/home.js", "assets/site/js")
    .js("resources/views/site/assets/js/internals.js", "assets/site/js")
    .sass("resources/views/site/assets/scss/style.scss", "assets/site/css")
    .purgeCss(purgeCssConfig)
    .options({
        postCss: [
            require("postcss-discard-comments")({
                removeAll: true
            })
        ]
    })
    .sourceMaps();

mix.js("resources/views/admin/assets/js/index.js", "assets/admin/js")
    .sass("resources/views/admin/assets/scss/index.scss", "assets/admin/css")
    .purgeCss(purgeCssConfig)
    .options({
        postCss: [
            require("postcss-discard-comments")({
                removeAll: true
            })
        ]
    })
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
