console.log('inicia SDK.');
//PR::: APP_USR-8464223c-ec51-46dd-9711-8b52d9600578 TEST::: TEST-df88f0fd-9bd4-4762-8e08-9814912fc5a2
const mp = new MercadoPago("APP_USR-8464223c-ec51-46dd-9711-8b52d9600578", {
    locale: "es-MX"
});

const bricksBuilder = mp.bricks();

const renderPaymentBrick = async () => {
    const idusrv = document.getElementById('idusrv').value;
    const costtoText = document.getElementById('costto').innerText;
    let amount = parseFloat(costtoText.replace(/[^0-9.-]+/g, "")).toFixed(2);

    if (amount <= 0) {
        console.error("El monto debe ser mayor que cero.");
        return;
    }

    const container = document.getElementById("paymentBrick_container");
    container.innerHTML = "";

    // 1. Verificar si el usuario tiene customer_id primero
    const userResponse = await fetch('get_user_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ idusrv })
    });
    
    const userData = await userResponse.json();
    const hasCustomerId = userData.customer_id !== null && userData.customer_id !== '';

    // 2. Verificar tarjetas guardadas solo si tiene customer_id
    let cardData = { cards: [] };
    if (hasCustomerId) {
        const cardResponse = await fetch('get_user_cards.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ idusrv, customer_id: userData.customer_id })
        });
        cardData = await cardResponse.json();
    }
    
    console.log("Card Data:", cardData);

    // Configuración del Brick con opción para guardar tarjeta
    const settings = {
        initialization: {
            amount: amount,
            payer: {
                email: userData.mail || "",
            }
        },
        customization: {
            paymentMethods: {
                creditCard: "all",
                debitCard: "all",
                mercadoPago: "all",
                //ticket: "all",
                //atm: "all"
            },
            visual: {
                style: {
                    theme: 'default'
                }
            }
        },
        callbacks: {
            onReady: () => {
                console.log('Checkout Bricks ready');
            },
            onSubmit: async ({ selectedPaymentMethod, formData }) => {
                formData.idusrv = idusrv;
                formData.amount = amount;
                formData.customer_id = userData.customer_id;
                
                // Determinar si es tarjeta y mostrar confirmación
                if (['credit_card', 'debit_card'].includes(selectedPaymentMethod)) {
                    formData.save_card = confirm('¿Deseas guardar esta tarjeta para futuras compras?');
                }

                try {
                    const response = await fetch('./process_payment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData),
                    });
                    
                    const result = await response.json();
                   // console.log('Payment Response:', result);
                    
                    if (result.card_id) {
                        // Actualizar la UI para mostrar la nueva tarjeta
                        await updateSavedCardsUI(idusrv, result.card_id, result.customer_id);
                    }
                    
                    mostrarResultadoPago(result);
                    return result;
                } catch (error) {
                    console.error('Error al realizar el pago:', error);
                    mostrarErrorPago(error);
                    throw error;
                }
            },
            onError: (error) => {
                console.error("Brick error:", error);
                mostrarErrorPago(error);
            }
        }
    };

    // Mostrar UI según tenga tarjetas o no
    if (hasCustomerId && cardData.cards && cardData.cards.length > 0) {
        renderSavedCardsUI(cardData.cards, idusrv, amount, settings);
    } else {
        await renderBrick(settings);
    }

    // Función para renderizar el Brick
    async function renderBrick(settings) {
        container.innerHTML = "";
        window.paymentBrickController = await bricksBuilder.create(
            "payment",
            "paymentBrick_container",
            settings
        );
    }
    function actualizarCards() {
        const gradients = [
            "linear-gradient(135deg, #1e3c72 40%, #2a5298 60%)",
            "linear-gradient(135deg, #ff512f 40%, #dd2476 60%)",
            "linear-gradient(135deg, #00c6ff 40%, #0072ff 60%)",
            "linear-gradient(135deg, #56ab2f 40%, #a8e063 60%)",
            "linear-gradient(135deg, #e65c00 40%, #f9d423 60%)",
            "linear-gradient(135deg, #614385 40%, #516395 60%)"
        ];
    
        const cards = document.querySelectorAll(".use-card-btn");
    
        if (cards.length > 0) {
            cards.forEach((card, index) => {
                if (index < gradients.length) {
                    card.style.background = gradients[index];
                }
            });
        }
    }
    // Función para mostrar tarjetas guardadas
    function renderSavedCardsUI(cards, userId, amount, brickSettings) {
        container.innerHTML = `
            <div class="saved-cards-header">
                <h3>Mis Tarjetas</h3>
            </div>
        `;

        cards.forEach(card => {
            const cardElement = document.createElement("div");
            cardElement.className = "saved-card";
            cardElement.innerHTML = `
                <div class="card-info">
                    <button class="btnl use-card-btn">
                        <div class="c7"></div>
                        <p class="c5"><span class="c6">•••• •••• ••••</span> ${card.last_four}</p>
                        <p class="c8">${card.card_type === 'credit' ? 'Crédito' : 'Débito'}</p>
                        <div class="c9"><img src="http://img.mlstatic.com/org-img/MP3/API/logos/${card.payment_method}.gif" ></div>
                    </button>
                </div>
                
            `;
            

            cardElement.querySelector('.use-card-btn').addEventListener('click', async () => {
                const cvv = prompt("Ingresa el CVV de la tarjeta:");
                if (!cvv || cvv.length < 3) {
                    alert("CVV inválido. Debe tener al menos 3 dígitos.");
                    return;
                }

                try {
                    const response = await fetch('./process_payment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            idusrv: userId,
                            card_id: card.card_id,
                            cvv: cvv,
                            amount: amount,
                            customer_id: card.customer_id
                        }),
                    });
                    
                    const result = await response.json();
                    mostrarResultadoPago(result);
                } catch (error) {
                    console.error('Error al pagar con tarjeta guardada:', error);
                    mostrarErrorPago(error);
                }
            });

            container.appendChild(cardElement);
        });

        // Botón para nueva tarjeta
        const newCardBtn = document.createElement("button");
        newCardBtn.className = "ver-mas-paquetes-btn";
        newCardBtn.innerHTML = '<ion-icon name="card-outline" aria-hidden="true" class="c4"></ion-icon> Nueva Tarjeta';
        newCardBtn.addEventListener('click', () => renderBrick(brickSettings));
        container.appendChild(newCardBtn);
        actualizarCards();
    }

    // Función para actualizar la UI después de guardar una tarjeta
    async function updateSavedCardsUI(userId, cardId, customerId) {
        // Obtener las tarjetas actualizadas
        const response = await fetch('get_user_cards.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ idusrv: userId })
        });
        
        const updatedCards = await response.json();
        if (updatedCards.cards && updatedCards.cards.length > 0) {
            // Volver a renderizar la lista de tarjetas
            const brickSettings = { /* tu configuración actual */ };
            renderSavedCardsUI(updatedCards.cards, userId, amount, brickSettings);
        }
    }
    function mostrarResultadoPago(resultado) {
        // Ocultar formulario de pago
        document.getElementById('data-pago').style.display = 'none';
        
        // Elemento donde mostraremos el resultado
        const resqueElement = document.getElementById("resque");
        
        // Plantillas para cada estado
        const templates = {
            approved: `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/checkmark.svg" alt="Checkmark" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">¡Compra Aprobada!</h2>
                    <p>Tu compra ha sido exitosa.</p>
                    <h3 style="color: var(--light-browm-2);">ID de pago: ${resultado.payment_id}</h3>
                    <h4 style="font-weight: 300; font-size: 1.5rem; line-height: 1;">
                        ¡Gracias por tu compra! En breve recibirás un mensaje de confirmación con tu recibo de pago.
                    </h4>
                    <a href="profile.php" style="margin-top: 25px" class="c3">Ir a Perfil</a>
                </div>
            `,
            rejected: `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/revoque.svg" alt="Pago rechazado" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">¡Compra Rechazada!</h2>
                    <p>Vuelve a intentar el pago nuevamente.</p>
                    <a href="checkout.php" style="margin-top: 25px" class="c3">Reintentar</a>
                </div>
            `,
            in_process: `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/wait.svg" alt="Pago en proceso" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">Procesando el pago...</h2>
                    <p>Recibirás una notificación cuando tu compra se haya procesado correctamente.</p>
                    <a href="profile.php" style="margin-top: 25px" class="c3">Ir a Perfil</a>
                </div>
            `,
            pending: `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/wait.svg" alt="Pago pendiente" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">Pago Pendiente...</h2>
                    <p>Recibirás una notificación cuando tu compra se haya procesado correctamente.</p>
                    <a href="profile.php" style="margin-top: 25px" class="c3">Ir a Perfil</a>
                </div>
            `,
            error: `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/revoque.svg" alt="Error en pago" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">¡Ocurrió un Error!</h2>
                    <p>Vuelve a intentar el pago nuevamente.</p>
                    <a href="checkout.php" style="margin-top: 25px" class="c3">Reintentar</a>
                </div>
            `
        };
    
        // Manejar el estado del pago
        if (resultado.payment_status === "approved") {
            resqueElement.innerHTML = templates.approved;
        } else if (resultado.payment_status === "rejected") {
            resqueElement.innerHTML = templates.rejected;
        } else if (resultado.payment_status === "in_process") {
            resqueElement.innerHTML = templates.in_process;
        } else if (resultado.payment_status === "pending") {
            // Abrir ventana para pagos pendientes que requieren acción (como PSE)
            if (resultado.transaction_details && resultado.transaction_details.external_resource_url) {
                window.open(resultado.transaction_details.external_resource_url, '_blank');
            }
            resqueElement.innerHTML = templates.pending;
        } else {
            resqueElement.innerHTML = templates.error;
        }
        
        // Mostrar el contenedor de resultados si estaba oculto
        resqueElement.style.display = 'flex';
    }
    // Helper para nombres de tarjetas
    function getCardBrandName(paymentMethod) {
        const brands = {
            'visa': 'Visa',
            'master': 'Mastercard',
            'amex': 'American Express',
            'diners': 'Diners Club',
            'debvisa': 'Visa Débito',
            'debmaster': 'Mastercard Débito'
        };
        return brands[paymentMethod] || paymentMethod;
    }

    // Función para mostrar errores
    function mostrarErrorPago(error) {
        const resque = document.getElementById("resque");
        resque.innerHTML = `
            <div class="error-payment">
                <h3>Error en el pago</h3>
                <p>${error.message || 'Ocurrió un error al procesar el pago'}</p>
                <button onclick="window.location.reload()" class="c3">Reintentar</button>
            </div>
        `;
    }
};

// Nuevo endpoint que necesitarás (get_user_data.php)
async function fetchUserData(userId) {
    const response = await fetch('get_user_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ idusrv: userId })
    });
    return await response.json();
}

function payTarjet(){
    
    renderPaymentBrick();
    document.getElementById('eleccion_pago').style.display = "none";
    document.getElementById('metodo_pago').style.display = "flex";
}