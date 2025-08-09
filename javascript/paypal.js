document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('paypal-button-container');
    if (!container) return;

    const hasItems = container.dataset.hasItems === '1';
    if (!hasItems) return; 

    

    paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'paypal'
        },
        createOrder: function (data, actions) {
            return fetch('paypal_create_order.php', {
                method: 'POST'
            })
                .then(res => res.json())
                .then(data => {
                    if (data.id) return data.id;
                    throw new Error(data.error || 'No se pudo crear la orden.');
                });
        },
        onApprove: function (data, actions) {
            return fetch('paypal_capture_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ orderID: data.orderID })
            })
                .then(res => res.json())
                .then(capture => {
                    if (capture.status === 'COMPLETED') {
                        
                        window.location.href = 'paypal_gracias.php?status=ok';
                    } else {
                        alert('El pago no se completó. Estado: ' + (capture.status || 'desconocido'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al capturar el pago.');
                });
        }
        ,
        onError: function (err) {
            console.error(err);
            alert('Error con PayPal. Intenta de nuevo.');
        }
    }).render('#paypal-button-container');
});
