<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />

</head>

<body>
    <div class="flex ">
        <input type="checkbox" id="drawer-toggle" class="relative sr-only peer" checked>
        <label for="drawer-toggle" class="absolute top-0 left-0 inline-block p-4 transition-all duration-500 bg-indigo-500 rounded-lg peer-checked:rotate-180 peer-checked:left-64">
            <div class="w-6 h-1 mb-3 -rotate-45 bg-white rounded-lg"></div>
            <div class="w-6 h-1 rotate-45 bg-white rounded-lg"></div>


        </label>
        <div class="fixed top-0 left-0 z-20 w-64 h-full transition-all duration-500 transform -translate-x-full bg-white shadow-lg peer-checked:translate-x-0">
            <div class="px-6 py-4">
                <h2 class="text-lg font-semibold">Drawer</h2>
                <p class="text-gray-500">This is a drawer.</p>
            </div>
        </div>
    </div>
</body>

</html>