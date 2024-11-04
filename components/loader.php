<style>
    .loader {
        display: flex;
        flex-direction: row;
        width: 5rem;
        height: 15px;
        justify-content: center;
        position: relative;
        align-self: center;
        text-align: center;
        width: 95%;
        background: #3293ed;
        height: 40px;
        left: 10px;
        border-radius: 5px;
        top: 20px;
    }

    .loader-items {
        width: 15px;
        height: 15px;
        background: #fff;
        border-radius: 50px;
        animation: loader 0.5s linear infinite;
        position: relative;
        top: 10px;
    }

     .loader-items:nth-child(1) {
        animation-delay: 0.3s;
    }

    .loader-items:nth-child(2) {
        animation-delay: 0.6s;
    }

   .loader-items:nth-child(3) {
        animation-delay: 0.9s;
    }

    .loader-items:nth-child(4) {
        animation-delay: 0.12s;
    }
    @keyframes loader{
    0%,100%{
        transform: scale(0.5);
        opacity: 0.7;
    }

    50%{
        transform: scale(0.7);
        opacity: 1.3;

    }
   
}
</style>

<div class="loader">
    <div class="loader-items"></div>
    <div class="loader-items"></div>
    <div class="loader-items"></div>
    <div class="loader-items"></div>
</div>