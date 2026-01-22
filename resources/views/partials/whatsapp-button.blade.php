<!-- WhatsApp Floating Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/818044550579?text=Hello"
       target="_blank"
       class="whatsapp-button"
       title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-text">Chat with us</span>
    </a>
</div>

<style>
/* WhatsApp Floating Button Styles */
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;
    animation: fadeInUp 0.5s ease-in-out;
}

.whatsapp-button {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 15px;
    gap: 10px;
}

.whatsapp-button:hover {
    background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
    color: #ffffff;
}

.whatsapp-button:hover .whatsapp-text {
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
}

.whatsapp-button i {
    font-size: 28px;
    animation: pulse 2s infinite;
    color: #ffffff;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
}

.whatsapp-text {
    font-size: 15px;
    white-space: nowrap;
    color: #ffffff;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.3px;
}

/* Pulse animation for WhatsApp icon */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

/* Fade in up animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive design - show only icon on mobile */
@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
    }

    .whatsapp-button {
        width: 60px;
        height: 60px;
        padding: 0;
        border-radius: 50%;
        justify-content: center;
    }

    .whatsapp-text {
        display: none;
    }

    .whatsapp-button i {
        font-size: 32px;
    }
}

/* Tablet view */
@media (min-width: 769px) and (max-width: 1024px) {
    .whatsapp-button {
        padding: 12px 18px;
    }

    .whatsapp-text {
        font-size: 13px;
    }
}
</style>
