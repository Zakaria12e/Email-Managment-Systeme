<template>
    <div class='flex space-x-2 justify-center items-center bg-white h-screen dark:invert overlay'>
        <span class='sr-only'>Loading...</span>
         <div class='h-8 w-8 bg-black rounded-full animate-bounce [animation-delay:-0.3s]'></div>
       <div class='h-8 w-8 bg-black rounded-full animate-bounce [animation-delay:-0.15s]'></div>
       <div class='h-8 w-8 bg-black rounded-full animate-bounce'></div>
    </div>

</template>
<style  scoped>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    z-index: 9999;
}
</style>
