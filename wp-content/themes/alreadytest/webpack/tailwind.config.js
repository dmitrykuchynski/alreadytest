/** @type {import('tailwindcss').Config} */

import { extract } from 'fluid-tailwind';
import { default as fluid } from 'fluid-tailwind';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
            xl: "1280px",
            '2xl': "1440px",
            '3xl': "1920px",
            '4xl': "2560px",
        },
        container: {

        },
        fontFamily: {
            "main": ["Okta Neue", "sans-serif"],
        },
        colors: {
            'green': {
                1: '#1cc7a8',
                2: '#21d6b5',
                DEFAULT: '#0d8570',
                3: '#0d8570',
                4: '#0E8570',
                5: '#1BC6A8',
            },
            'gray': {
                1: '#fafafc',
                2: '#e0e3eb',
                3: '#d9d9d9',
                4: '#CAD1DF',
                5: '#9FACC5',
                6: '#43506A',
                7: '#fafbfd',
                8: '#fafbfdb3',
                9: '#fafbfd33',
                DEFAULT: '#E1E4EB',
            },
            'orange': {
                1: '#F33A12',
                2: '#F33A12',
                3: '#F33A12',
                4: '#F33A12',
                5: '#e5d3d5',
                6: '#ec421d',
                DEFAULT: '#F33A12'
            },
            'dark': {
                1: '#213659',
                2: '#243047',
                3: '#142645',
                4: '#0d1c3d',
                5: '#0d1c3b',
                6: '#001229',
                7: '#0C1C3C',
                8: '#22355A',
                9: '#14314a',
                10: '#15254533',
                DEFAULT: '#152545',
            },
            'white': '#ffffff',
            'transparent': 'transparent',
        },
        extend: {
        }
    },
    plugins: [
        forms({
            strategy: "base",
        }),
        fluid.default({
            checkSC144: false,
        }),
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
