/** @type {import('tailwindcss').Config} */

import fluid, { extract } from 'fluid-tailwind'

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: ['selector', '[data-mode="dark"]'],
    content: {
        relative: true,
        files: [
            // https://tailwindcss.com/docs/content-configuration
            // TailWind documentation says absolutely do not have TW scan CSS files. Leaving this here for now.
            "../*.{php,html}",
            "../templates/**/*.{php,html}",
            "./src/**/*.{scss,js}",
            "!./node_modules/**/*",
            "!../acf-json/**/*",
            "!../assets/**/*",
        ],
        extract
    },
    theme: {
        fluid: {
            defaultScreens: ['320px', '1920px']
        },
        screens: {
            xs: "500px",
            sm: "640px",
            md: "768px",
            lg: "1024px",
            xl: "1200px",
            '2xl': "1440px",
            '3xl': "1920px",
        },
        container: {

        },
        fontFamily: {
            "code": ["Fira Code", "sans-serif"],
            "main": ["Okta Neue", "sans-serif"],
        },
        colors: {
            'green': {
                1: '#1cc7a8',
                2: '#21d6b5',
                DEFAULT: '#0d8570',
                3: '#0d8570',
            },
            'gray': {
                1: '#fafafc',
                2: '#e0e3eb',
                3: '#d9d9d9',
                DEFAULT: '#c9d1e0',
            },
            'orange': {
                1: '#f05736',
                2: '#ff5936',
                DEFAULT: '#eb421c'
            },
            'dark': {
                1: '#213659',
                2: '#243047',
                3: '#142645',
                4: '#0d1c3d',
                5: '#0d1c3b',
                6: '#001229',
                DEFAULT: '#0d0d0d',
            },
            'white': '#ffffff',
        },
        extend: {
        }
    },
    plugins: [
        require("@tailwindcss/forms")({
            strategy: "base",
        }),
        fluid({
            checkSC144: false
        })
    ],
    corePlugins: {
        backdropOpacity: false,
        backgroundOpacity: false,
        borderOpacity: false,
        divideOpacity: false,
        ringOpacity: false,
        textOpacity: false
    }
}
