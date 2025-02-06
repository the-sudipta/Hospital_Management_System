<div id="loadingOverlay">
    <div class="loader"></div>
</div>

<style>
    /* Full-page overlay */
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85); /* Darker semi-transparent */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    /* Modern Glow Loader */
    .loader {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0, 140, 255, 0.9) 10%, rgba(0, 140, 255, 0.4) 50%, transparent 60%);
        box-shadow: 0 0 20px rgba(0, 140, 255, 0.7), 0 0 40px rgba(0, 140, 255, 0.5);
        animation: spin 1.5s linear infinite, glow 1.5s alternate infinite ease-in-out;
    }

    /* Smooth rotation animation */
    @keyframes spin {
        0% { transform: rotate(0deg) scale(0.9); }
        100% { transform: rotate(360deg) scale(1.1); }
    }

    /* Glowing effect */
    @keyframes glow {
        0% { box-shadow: 0 0 15px rgba(0, 140, 255, 0.6), 0 0 30px rgba(0, 140, 255, 0.4); }
        100% { box-shadow: 0 0 25px rgba(0, 140, 255, 0.9), 0 0 50px rgba(0, 140, 255, 0.7); }
    }


</style>
