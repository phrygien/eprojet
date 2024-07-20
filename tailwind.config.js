import forms from "@tailwindcss/forms"

/** @type {import('tailwindcss').Config} */
export default {
  daisyui: {
    themes: [
      "light",
      "dark",
      "cupcake",
      "bumblebee",
      "emerald",
      "corporate",
      "synthwave",
      "retro",
      "cyberpunk",
      "valentine",
      "halloween",
      "garden",
      "forest",
      "aqua",
      "lofi",
      "pastel",
      "fantasy",
      "wireframe",
      "black",
      "luxury",
      "dracula",
      "cmyk",
      "autumn",
      "business",
      "acid",
      "lemonade",
      "night",
      "coffee",
      "winter",
      "dim",
      "nord",
      "sunset",
    ],
  },
  darkMode: 'class',
  content: [
		"./resources/**/*.blade.php",
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
     './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
	],
  theme: {
    extend: {},
  },
  plugins: [
		forms,
		require("daisyui")
	],
}

