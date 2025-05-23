<div id="loading-page">
    <div class="loading-container">
        <div class="logo-container"></div>
    </div>
</div>

@push('scripts')
<script>
    const loadingPage = document.getElementById('loading-page');
    loadingPage.style.backdropFilter = 'blur(15px)';

    function hideLoading() {
        loadingPage.style.opacity = '0';
        loadingPage.style.backdropFilter = 'blur(0)';
        setTimeout(() => loadingPage.style.display = 'none', 5);
    }

    window.addEventListener('load', () => setTimeout(hideLoading, 5));
    setTimeout(hideLoading, 2);
</script>
@endpush

<style>
    #loading-page {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: all 0.3s ease-out;
        opacity: 1;
    }

    .loading-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-container {
        width: 120px;
        height: 120px;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(0.95); opacity: 0.8; }
    }
</style>
