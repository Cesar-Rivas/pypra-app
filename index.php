<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diseño Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Three.js y complementos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
    header {
        height: 17vh;
        background-color: var(--bs-dark);
        position: sticky;
        top: 0;
        z-index: 1020;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .square-box {
        aspect-ratio: 1/1;
        width: 90%;
        border-radius: 1rem;
        background-color: #dee2e6;
        margin: 0 auto 20px;
    }

    .styled-table {
        width: 80%;
        margin: auto;
        background-color: #fff;
    }

    .styled-table td,
    .styled-table th {
        padding: 0.5rem;
    }

    .styled-table .key-cell {
        background-color: var(--bs-dark);
        color: #fff;
        font-weight: bold;
    }

    .styled-table .full-width-row {
        background-color: var(--bs-dark);
        color: #fff;
        font-weight: bold;
        text-align: center;
    }

    .styled-table .empty-row {
        height: 3rem;
        text-align: center;
    }

    .icon-btn {
        border: none;
        border-radius: 0.75rem;
        background-color: #e9ecef;
        color: #6c757d;
        padding: 0.6rem 1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background-color 0.2s, color 0.2s;
    }

    .icon-btn:hover {
        background-color: #343a40;
        color: #fff;
    }

    .icon-btn i {
        font-size: 1.1rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
    }

    .contact-btn-container {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .contact-btn {
        max-width: 200px;
    }
    </style>
</head>

<body class="bg-light">

    <!-- Sticky header con solo imagen -->
    <header>
        <img src="pypra_logo.png" alt="Logo" style="max-height:90%; width:auto">
    </header>

    <!-- Título fuera del header -->
    <div class="container text-center mt-4">
        <h2 class="fw-bold">P09121-092-209</h2>
    </div>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12 col-md-6 text-center">
                <div class="square-box d-flex justify-content-center align-items-center">
                    <div id="viewer"
                        class="flex-grow-1 position-relative d-flex justify-content-center align-items-center" style="
  border:2px solid gray; border-radius: 15px; height:100%; width:100%; overflow:hidden">
                        <!-- Three.js canvas va aquí -->
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6" style="padding: 20px;">
                <div class="row mb-3" style="text-align: center;">
                    <h4>Box Information</h4>
                </div>

                <div class="row mb-3">
                    <table class="table styled-table">
                        <tbody>
                            <tr>
                                <td class="key-cell">Work Order</td>
                                <td id="workOrder">CLIE-250123</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Client</td>
                                <td id="client">LEGRAND</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Part Number</td>
                                <td id="partNumber">P09121-092-209</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Description</td>
                                <td id="description">LID, E92, 1 FEATURE</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Pcs per box</td>
                                <td id="pcsPerBox">50</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Material</td>
                                <td id="material">Aluminum</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Purchase Order</td>
                                <td id="purchaseOrder">45001234</td>
                            </tr>
                            <tr>
                                <td class="key-cell">Item line</td>
                                <td id="itemLine">010</td>
                            </tr>
                            <tr>
                                <td class="full-width-row" colspan="2">Additional Info</td>
                            </tr>
                            <tr>
                                <td class="empty-row" colspan="2">Deliver to Tecma</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="row mb-3">
                    <div class="col-12 button-group">
                        <button class="icon-btn flex-fill"
                            onclick="window.open('https://pypraofficialsite.com/', '_blank')">
                            <i class="bi bi-globe2"></i><span>Official Site</span>
                        </button>
                        <button class="icon-btn flex-fill" onclick="copyTable()">
                            <i class="bi bi-clipboard"></i><span>Copy Info</span>
                        </button>
                        <button class="icon-btn flex-fill" onclick="shareUrl()">
                            <i class="bi bi-share-fill"></i><span>Share</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="contact-btn-container w-100">
                        <a class="icon-btn contact-btn text-center text-decoration-none"
                            href="https://pypraofficialsite.com/contact" target="_blank">
                            <i class="bi bi-headset"></i><span>Contact</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div id="modelSelector" class="bg-dark text-light p-2" style="width: 200px; display:none">
            <!-- Dinámicamente botones o dropdown -->
        </div>
    </div>
        <script src="script.js"></script>

        <script>
        function copyTable() {
            const rows = document.querySelectorAll('.styled-table tbody tr');
            let output = '';
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 2) {
                    const key = cells[0].innerText.trim();
                    const value = cells[1].innerText.trim();
                    output += $ {
                        key
                    }: $ {
                        value
                    }\
                    n;
                }
            });
            navigator.clipboard.writeText(output).then(() => alert('Copied!'));
        }

        function shareUrl() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(console.error);
            } else {
                alert("Sharing not supported on this device.");
            }
        }
        </script>

</body>

</html>