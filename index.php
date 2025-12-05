<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QuickPOS - Modern Point of Sale System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: oklch(0.40 0.15 285);
      --primary-dark: oklch(0.35 0.15 285);
      --bg: oklch(0.98 0 0);
      --card: oklch(1 0 0);
      --text: oklch(0.12 0 0);
      --text-light: oklch(0.50 0 0);
      --border: oklch(0.92 0 0);
      --accent: oklch(0.56 0.18 190);
    }
    body { font-family: 'Geist', sans-serif; background: var(--bg); color: var(--text); }
    .glass { background: var(--card); backdrop-filter: blur(20px); border: 1px solid var(--border); }
    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); }
    .btn-primary:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,212,170,.35); }
    .card-hover:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(0,0,0,.1); }
    .badge { background: rgba(67, 97, 238, 0.1); color: var(--primary); border: 1px solid rgba(67, 97, 238, 0.3); }
    .pill-active { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; }
    
    /* Added dashboard button hover effects */
    .dashboard-btn:hover {
      fill: var(--primary) !important;
      filter: brightness(1.1);
      box-shadow: 0 0 16px rgba(67, 97, 238, 0.4);
    }
    .dashboard-btn:hover ~ .dashboard-btn-text,
    .dashboard-btn:hover + .dashboard-btn-text {
      fill: white !important;
    }
    
    /* Toggle switch styling - tighter spacing */
    .toggle-switch { display: inline-flex; align-items: center; gap: 1rem; background: white; border: 2px solid #e2e8f0; border-radius: 2rem; padding: 0.5rem; position: relative; }
    .toggle-switch input { display: none; }
    .toggle-switch label { cursor: pointer; }
    .toggle-dot { position: absolute; width: 2rem; height: 2rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 50%; transition: all 0.3s ease; }
    .toggle-switch input:checked ~ .toggle-dot { transform: translateX(calc(100% + 0.5rem)); }
    
    /* Billing toggle: improved spacing and "Save 20%" label positioning */
    .billing-toggle-wrap { display:flex; align-items:center; justify-content:center; gap:2.4rem; flex-wrap:wrap; margin-bottom:4rem; }
    .billing-label { font-weight:600; color:var(--text); font-size:1rem; }
    .toggle-and-savings { display:flex; align-items:center; gap:0.6rem; }
    .billing-toggle {
      width:68px; height:36px; border-radius:999px; padding:3px; position:relative;
      background:rgba(67, 97, 238, 0.1); border:2px solid rgba(67, 97, 238, 0.25); box-sizing:content-box;
      display:inline-block;
    }
    .billing-toggle input { display:none; }
    .billing-dot {
      position:absolute; left:3px; top:3px;
      width:30px; height:30px; border-radius:50%;
      background:linear-gradient(180deg, var(--primary), var(--accent));
      transition:transform .26s ease, background .26s ease;
      box-shadow: 0 6px 14px rgba(67, 97, 238, 0.14), inset 0 -6px 12px rgba(255,255,255,0.06);
      z-index:2;
    }
    .billing-dot::after {
      content:""; position:absolute; inset:7px; border-radius:50%;
      background: rgba(0,0,0,0.12);
    }
    .billing-toggle input:checked + .billing-dot {
      transform: translateX(30px);
      background: linear-gradient(90deg, var(--primary), var(--accent));
      box-shadow: 0 6px 14px rgba(67, 97, 238, 0.14), inset 0 -6px 12px rgba(255,255,255,0.06);
    }
    .billing-save { color:var(--primary); font-weight:700; font-size:0.9rem; white-space:nowrap; }

    .pricing-grid { grid-template-columns: repeat(3,1fr); }
    
    /* Updated pricing cards: outer border stays grey always, only inner rectangle hovers */
    .pricing-card {
      position:relative; padding:0.75rem; border-radius:1.5rem; text-align:left;
      transition: none;
      cursor:pointer;
      border:2px solid rgba(16,24,40,0.1);
      background: linear-gradient(180deg,#ffffff,#fbffff);
    }

    /* Inner rectangle with hover effects */
    .pricing-inner {
      position:relative;
      border-radius:1.25rem; padding:2.25rem; background:linear-gradient(180deg,#ffffff,#f6fbfb);
      border:2px solid rgba(16,24,40,0.06);
      box-shadow: 0 8px 30px rgba(16,24,40,0.04);
      transition: border-color .3s ease, box-shadow .3s ease, background .3s ease, transform .28s cubic-bezier(.22,1,.36,1);
      overflow:visible;
    }

    /* Inner rectangle hover - only this gets the hover effect */
    .pricing-card:hover .pricing-inner,
    .pricing-card:focus-within .pricing-inner {
      transform: translateY(-8px);
      box-shadow: 0 28px 60px rgba(16,24,40,0.12), inset 0 0 24px rgba(67, 97, 238, 0.06);
      background: linear-gradient(180deg,#ffffff,#f0fffe);
      border-color: rgba(67, 97, 238, 0.3);
    }

    /* Pro (popular) always shows inner rectangle with teal border, outer stays grey */
    .pricing-card.popular .pricing-inner {
      border:2px solid rgba(67, 97, 238, 0.3);
      box-shadow: 0 20px 40px rgba(67, 97, 238, 0.1);
      background: linear-gradient(180deg,#f8fbff,#eef8ff);
    }

    /* Outer border for pro card stays grey on hover - NO HIGHLIGHT */
    .pricing-card.popular {
      border-color: rgba(16,24,40,0.1) !important;
    }
    .pricing-card.popular:hover {
      border-color: rgba(16,24,40,0.1) !important;
      transform: none !important;
    }

    /* pricing badge moved inside the inner rectangle and styled as rounded rectangle - POSITIONED HALF ABOVE BOUNDARY */
    .pricing-badge {
      display:inline-block;
      padding:8px 14px;
      border-radius:999px;
      font-weight:800;
      font-size:0.75rem;
      color:white;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      box-shadow: 0 8px 22px rgba(67, 97, 238, 0.12);
      position:absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      z-index:3;
      animation: popupBlink 3s ease-in-out infinite;
    }

    /* price row: dollar, amount and period on same baseline */
    .pricing-price-row { display:flex; align-items:baseline; gap:8px; margin-bottom:6px; }
    .pricing-price-row .price-currency { font-size:1.2rem; font-weight:800; color:var(--primary); }
    .pricing-price-row .price-amount { font-size:3.25rem; font-weight:900; color:var(--primary); line-height:1; display:inline-flex; gap:6px; align-items:baseline; }
    .pricing-price-row .price-period { font-size:0.95rem; color:var(--text-light); margin-left:6px; display:inline-flex; align-items:baseline; }

    .pricing-card.popular .pricing-price-row .price-amount { color: var(--primary); }

    /* Make Basic and Enterprise prices green */
    .pricing-card-basic .pricing-price-row .price-amount,
    .pricing-card-enterprise .pricing-price-row .price-amount {
      color: var(--primary);
    }

    /* Make plan names bold */
    .pricing-title {
      font-weight: 800;
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }

    /* Change plan name color to green on hover */
    .pricing-card:hover .pricing-title {
      color: var(--primary);
    }

    /* Updated pricing card spacing */
    .pricing-card ul {
      margin-top: 2rem;
    }
    
    .pricing-card ul li {
      margin-bottom: 1rem;
    }

    .pricing-sub {
      margin-bottom: 2rem !important;
    }

    @keyframes popupBlink {
      0% { transform: translateX(-50%) translateY(0) scale(1); box-shadow: 0 12px 20px rgba(0,0,0,0.05); }
      50% { transform: translateX(-50%) translateY(-6px) scale(1.02); box-shadow: 0 28px 44px rgba(67, 97, 238, 0.12); }
      100% { transform: translateX(-50%) translateY(0) scale(1); box-shadow: 0 12px 20px rgba(0,0,0,0.05); }
    }

    /* ensure monthly/annual toggle visibility styles */
    .monthly-price { display: inline; }
    .annual-price { display: inline; }
    .annual-price.hidden, .monthly-price.hidden { display: none !important; }

    /* ====== FEATURES: Updated with grey border and green hover ====== */
    .feature-card { 
      --feature-border: rgba(16,24,40,0.1);
      background: white;
      border-radius: 1rem;
      box-shadow: 0 8px 30px rgba(16,24,40,0.04);
      transition: transform .32s cubic-bezier(.22,1,.36,1), box-shadow .32s ease, border-color .25s ease, background .25s ease;
      cursor: pointer;
      padding: 1.5rem;
      border: 2px solid var(--feature-border);
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 0.5rem;
      will-change: transform;
      overflow: visible;
      text-align: left;
    }
    .feature-card > * { text-align: left; }

    .feature-card:hover,
    .feature-card:focus-within {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(16,24,40,0.06);
      background: linear-gradient(135deg,#ffffff,#f7fffb);
      border-color: var(--primary);
      outline: none;
    }

    .feature-emoji {
      font-size: 3rem;
      color: var(--primary);
      position: relative;
      transform: translate(0,0) scale(1);
      transition: transform .35s cubic-bezier(0.22,1,0.36,1), background .25s ease, border-color .25s ease, box-shadow .25s ease;
      background: rgba(67, 97, 238, 0.04);
      padding: 0.45rem 0.6rem;
      border-radius: 0.75rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 2px solid transparent;
      z-index: 2;
    }

    .feature-card:hover .feature-emoji,
    .feature-card:focus-within .feature-emoji {
      transform: translate(-34px, -6px) scale(1.03);
      background: rgba(67, 97, 238, 0.12);
      border-color: rgba(67, 97, 238, 0.28);
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.08);
      z-index: 20;
    }

    .feature-card h3 { transition: color .25s ease; margin:0; }
    .feature-card:hover h3,
    .feature-card:focus-within h3 { color: var(--primary); }

    .feature-sep {
      height: 1px;
      width: 100%;
      background: rgba(0,0,0,0.06);
      margin: 0.6rem 0 0.5rem;
      border-radius: 2px;
    }

    .feature-detail {
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height .36s cubic-bezier(.22,1,.36,1), opacity .28s ease, transform .28s ease;
      transform: translateY(-6px);
      width: 100%;
      color: var(--text-light);
      font-size: 0.95rem;
      line-height: 1.5;
      padding-top: 0;
      margin: 0;
    }
    .feature-card:hover .feature-detail,
    .feature-card:focus-within .feature-detail {
      max-height: 320px;
      opacity: 1;
      transform: translateY(0);
      padding-top: 1rem;
    }

    .feature-divider {
      height: 4px;
      width: 100%;
      margin: 0.9rem 0 0;
      border-radius: 999px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      box-shadow: 0 6px 18px rgba(16,24,40,0.04);
      opacity: 0;
      transform: scaleX(0);
      transform-origin: left;
      transition: opacity .35s ease, transform .35s cubic-bezier(.22,1,.36,1);
    }
    .feature-card:hover .feature-divider,
    .feature-card:focus-within .feature-divider {
      opacity: 1;
      transform: scaleX(1);
    }

    .contact-form-group {
      text-align: left;
      margin-top: 1rem;
    }
    .contact-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 700;
      color: var(--text);
      transition: color .18s ease;
      font-size: 0.95rem;
    }
    .contact-input {
      width: 100%;
      padding: 1.05rem 1.25rem;
      border-radius: 14px;
      border: 2px solid rgba(16,24,40,0.06);
      background: linear-gradient(180deg,#ffffff,#fbffff);
      box-shadow: none;
      transition: border-color .15s ease, box-shadow .18s ease, transform .12s ease;
      font-size: 1rem;
      color: var(--text);
      outline: none;
    }
    .contact-input::placeholder { color: #9aa3b2; }

    .contact-input:hover {
      transform: translateY(-2px);
      border-color: rgba(67, 97, 238, 0.34);
      box-shadow: 0 10px 24px rgba(67, 97, 238, 0.06);
    }

    .contact-form-group:focus-within .contact-label {
      color: var(--primary);
    }
    .contact-input:focus {
      transform: translateY(-4px);
      border-color: var(--primary);
      box-shadow: 0 18px 40px rgba(67, 97, 238, 0.12), inset 0 2px 6px rgba(255,255,255,0.03);
    }

    .contact-input.resize-none { min-height: 160px; }

    nav a {
      position: relative;
      padding-bottom: 0.5rem;
    }
    nav a::after {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      bottom: -6px;
      height: 4px;
      border-radius: 999px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform .18s ease, opacity .18s ease;
      opacity: 0;
      pointer-events: none;
    }
    nav a:hover::after,
    nav a:focus::after {
      transform: scaleX(1);
      opacity: 1;
    }

    footer a {
      position: relative;
      padding-bottom: 0.25rem;
    }
    footer a::after {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      bottom: -5px;
      height: 3px;
      border-radius: 999px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform .18s ease, opacity .18s ease;
      opacity: 0;
      pointer-events: none;
    }
    footer a:hover::after,
    footer a:focus::after {
      transform: scaleX(1);
      opacity: 1;
    }

    /* ===== FAQ: Updated with grey line and answer styling ===== */
    #faq .faq-item {
      border: 2px solid rgba(16,24,40,0.06);
      border-radius: 14px;
      background: #ffffff;
      padding: 1.25rem 1.5rem;
      margin-bottom: 1rem;
      transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
      cursor: pointer;
      overflow: visible;
    }

    #faq .faq-question {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      font-weight: 800;
      font-size: 1.05rem;
      background: white;
      padding: 0;
      margin: 0;
    }

    #faq .faq-arrow {
      font-size: 1.25rem;
      color: var(--text-light);
      transition: transform .25s ease, color .25s ease;
    }

    #faq .faq-answer {
      max-height: 0;
      overflow: hidden;
      opacity: 0;
      transition: max-height .3s ease, opacity .3s ease;
      color: var(--text-light);
      line-height: 1.8;
      font-size: 1rem;
      margin-top: 0;
      padding-top: 0;
      text-align: left;
      border-top: none;
    }

    #faq .faq-item.active {
      border-color: rgba(67, 97, 238, 0.40);
      box-shadow: 0 14px 40px rgba(67, 97, 238, 0.08);
      background: white;
    }

    #faq .faq-item.active .faq-arrow {
      transform: rotate(180deg);
      color: var(--primary);
    }

    #faq .faq-item.active .faq-answer {
      max-height: 500px;
      opacity: 1;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid #e2e8f0;
      color: var(--primary);
    }

    #faq .faq-item:hover {
      border-color: rgba(67, 97, 238, 0.22);
      box-shadow: 0 10px 30px rgba(67, 97, 238, 0.06);
      background: white;
    }

    /* Multi-step signup modal styles */
    .signup-progress {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 2rem;
      justify-content: center;
    }

    .signup-progress-bar {
      height: 6px;
      flex: 1;
      max-width: 80px;
      border-radius: 999px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transition: all 0.3s ease;
    }

    .signup-progress-bar.inactive {
      background: #e2e8f0;
    }

    .signup-step {
      display: none;
    }

    .signup-step.active {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .signup-buttons {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }

    .signup-button-back {
      flex: 1;
      padding: 1rem 1.5rem;
      border-radius: 14px;
      border: 2px solid rgba(67, 97, 238, 0.3);
      background: white;
      color: var(--text);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .signup-button-back:hover {
      border-color: var(--primary);
      background: rgba(67, 97, 238, 0.05);
    }

    .signup-button-next {
      flex: 1;
      padding: 1rem 1.5rem;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .signup-button-next:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
    }

    /* ===== SECTION BACKGROUNDS ===== */
    /* Hero Section Background */
    .hero-bg {
      background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(0,212,170,0.03) 100%);
      position: relative;
      overflow: hidden;
    }
    
    /* Features Section Background */
    .features-bg {
      background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(0,212,170,0.02) 50%, rgba(67, 97, 238, 0.02) 100%);
    }
    
    /* Testimonials Section Background */
    .testimonials-bg {
      background: linear-gradient(135deg, rgba(0,212,170,0.02) 0%, rgba(67, 97, 238, 0.02) 100%);
    }
    
    /* FAQ Section Background */
    .faq-bg {
      background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(0,212,170,0.02) 100%);
    }
    
    /* Pricing Section Background */
    .pricing-bg {
      background: linear-gradient(135deg, rgba(0,212,170,0.02) 0%, rgba(67, 97, 238, 0.02) 50%, rgba(0,212,170,0.02) 100%);
    }
    
    /* Contact Section Background */
    .contact-bg {
      background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(0,212,170,0.02) 100%);
    }
    
    /* Footer Section Background */
    .footer-bg {
      background: linear-gradient(135deg, rgba(0,212,170,0.02) 0%, rgba(67, 97, 238, 0.02) 100%);
    }

    /* Testimonial active state styles */
    .testimonial-active {
      box-shadow: 0 28px 60px rgba(16,24,40,0.12) !important;
      border-color: var(--primary) !important;
      transform: scale(1.02);
    }
    
    .testimonial-active .testimonial-emoji {
      transform: scale(1.1);
      transition: transform 0.3s ease;
    }
    
    #testimonialCard {
      transition: all 0.3s ease;
      cursor: pointer;
    }

    #testimonialCard:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(67, 97, 238, 0.2);
      border-color: var(--primary);
    }

    #testimonialCard:hover .testimonial-emoji {
      transform: scale(1.2);
      transition: transform 0.3s ease;
    }
  </style>
</head>
<body class="min-h-screen">

  <!-- Navigation -->
  <nav class="fixed top-0 inset-x-0 z-50 glass backdrop-blur-xl border-b border-[var(--border)]">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] flex items-center justify-center text-white font-bold text-xl shadow-lg">
          <i class="fas fa-cash-register"></i>
        </div>
        <span class="text-2xl font-bold bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] bg-clip-text text-transparent">QuickPOS</span>
      </div>
      <div class="hidden md:flex gap-10 font-medium">
        <a href="#features" class="text-[var(--text-light)] hover:text-[var(--primary)] transition">Features</a>
        <a href="#pricing" class="text-[var(--text-light)] hover:text-[var(--primary)] transition">Pricing</a>
        <a href="#testimonials" class="text-[var(--text-light)] hover:text-[var(--primary)] transition">Testimonials</a>
        <a href="#faq" class="text-[var(--text-light)] hover:text-[var(--primary)] transition">FAQ</a>
        <a href="#contact" class="text-[var(--text-light)] hover:text-[var(--primary)] transition">Contact</a>
      </div>
      <button onclick="openSignup()" class="px-8 py-3 rounded-full btn-primary text-white font-semibold shadow-lg">
        Sign Up
      </button>
    </div>
  </nav>

  <!-- Hero -->
  <section class="pt-32 pb-24 px-6 relative overflow-hidden hero-bg">
    <div class="absolute inset-0">
      <div class="absolute top-20 left-10 w-96 h-96 bg-[var(--primary)] rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
      <div class="absolute bottom-20 right-10 w-80 h-80 bg-[var(--accent)] rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay:2s"></div>
    </div>

    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center relative z-10">
      <div class="space-y-8">
        <div class="inline-block px-5 py-2 rounded-full badge font-semibold text-sm">
          New: AI-Powered Insights
        </div>
        <h1 class="text-6xl md:text-7xl font-black leading-tight">
          The Last <span class="bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] bg-clip-text text-transparent">POS</span><br>
          <span class="bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] bg-clip-text text-transparent">System</span> You'll Ever Need
        </h1>
        <p class="text-xl text-[var(--text-light)] max-w-lg">
          QuickPOS is the all-in-one point of sale solution designed for modern businesses. Streamline operations, boost sales, and delight customers with industry-leading technology.
        </p>
        <div class="flex flex-col sm:flex-row gap-5">
          <button onclick="openSignup()" class="px-10 py-5 rounded-full btn-primary text-white font-bold text-center shadow-xl">
            Get Started for Free
          </button>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-3xl text-yellow-500">*****</span>
          <span class="text-[var(--text-light)] font-medium">Trusted by 10,000+ businesses</span>
        </div>
      </div>

      <!-- Dashboard Mockup -->
      <div>
        <div class="glass rounded-3xl p-12 shadow-2xl card-hover border border-[var(--border)]">
          <div class="text-center space-y-8">
            <svg viewBox="0 0 380 780" class="w-80 mx-auto drop-shadow-2xl">
              <defs>
                <linearGradient id="phonegrad" x1="0%" y1="0%" x2="100%">
                  <stop offset="0%" stop-color="var(--primary)"/>
                  <stop offset="100%" stop-color="var(--accent)"/>
                </linearGradient>
              </defs>
              <rect x="15" y="15" width="350" height="750" rx="60" fill="white" stroke="url(#phonegrad)" stroke-width="10"/>
              <rect x="40" y="60" width="300" height="660" rx="40" fill="#f0fffe"/>
              <text x="190" y="140" text-anchor="middle" font-size="22" font-weight="bold" fill="#1e293b">QuickPOS Dashboard</text>
              <text x="190" y="180" text-anchor="middle" font-size="16" fill="#64748b">Real-time Sales & Analytics</text>

              <!-- Dashboard buttons with hover effect -->
              <g transform="translate(70,240)">
                <rect width="240" height="40" rx="20" fill="#e0fcf8" class="dashboard-btn" style="cursor:pointer; transition: all 0.3s ease;"/>
                <text x="120" y="26" text-anchor="middle" font-size="14" fill="var(--primary)" class="dashboard-btn-text" style="pointer-events:none;">Real-time Analytics</text>
              </g>
              <g transform="translate(70,290)">
                <rect width="140" height="36" rx="18" fill="#e0fcf8" class="dashboard-btn" style="cursor:pointer; transition: all 0.3s ease;"/>
                <text x="70" y="24" text-anchor="middle" font-size="13" fill="var(--primary)" class="dashboard-btn-text" style="pointer-events:none;">Multi-store</text>
              </g>
              <g transform="translate(220,290)">
                <rect width="90" height="36" rx="18" fill="#e0fcf8" class="dashboard-btn" style="cursor:pointer; transition: all 0.3s ease;"/>
                <text x="45" y="24" text-anchor="middle" font-size="13" fill="var(--primary)" class="dashboard-btn-text" style="pointer-events:none;">AI Insights</text>
              </g>

              <text x="190" y="420" text-anchor="middle" font-size="48" font-weight="900" fill="var(--primary)">500,000</text>
              <text x="190" y="470" text-anchor="middle" font-size="16" fill="#64748b">Transactions</text>
              <text x="100" y="580" text-anchor="middle" font-size="32" font-weight="900" fill="var(--primary)">150</text>
              <text x="100" y="610" text-anchor="middle" font-size="14" fill="#64748b">Countries</text>
              <text x="280" y="580" text-anchor="middle" font-size="32" font-weight="900" fill="var(--primary)">99.9%</text>
              <text x="280" y="610" text-anchor="middle" font-size="14" fill="#64748b">Uptime</text>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features with Tabs -->
  <section id="features" class="py-24 px-6 features-bg">
    <div class="max-w-7xl mx-auto text-center space-y-16">
      <div>
        <div class="inline-block px-6 py-3 rounded-full badge font-bold">POWERFUL FEATURES</div>
        <h2 class="text-5xl md:text-5xl font-black mt-8">Everything You Need</h2>
      </div>

      <div class="flex justify-center gap-4 mb-12">
        <button id="salesTab" class="px-8 py-3 rounded-full pill-active text-white font-bold shadow-lg transition-all duration-300">🛒 Sales</button>
        <button id="inventoryTab" class="px-8 py-3 rounded-full bg-white/80 border border-gray-200 text-[var(--text)] font-semibold hover:bg-[var(--primary)] hover:text-white transition-all duration-300">📦 Inventory</button>
      </div>

      <!-- Sales Features -->
      <div id="salesFeatures" class="grid md:grid-cols-4 gap-8">
        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">💳</div>
          <h3 class="text-2xl font-bold">Fast Checkout</h3>
          <p class="text-[var(--text-light)]">Lightning-quick transactions</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Process payments in under 5 seconds with our optimized checkout flow.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>

        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">📱</div>
          <h3 class="text-2xl font-bold">Mobile Friendly</h3>
          <p class="text-[var(--text-light)]">Sell anywhere, anytime</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Full mobile app support with offline capabilities for sales on the go.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>

        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">🎁</div>
          <h3 class="text-2xl font-bold">Loyalty Programs</h3>
          <p class="text-[var(--text-light)]">Reward repeat customers</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Build customer loyalty with flexible reward programs and promotions.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>

        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">📊</div>
          <h3 class="text-2xl font-bold">Sales Reports</h3>
          <p class="text-[var(--text-light)]">Real-time insights</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Get detailed analytics and real-time sales data to drive your business.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>
      </div>

      <!-- Inventory Features -->
      <div id="inventoryFeatures" class="hidden grid md:grid-cols-4 gap-8">
        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">📦</div>
          <h3 class="text-2xl font-bold">Stock Management</h3>
          <p class="text-[var(--text-light)]">Real-time tracking</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Track inventory across locations with real-time stock level updates.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>
        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">🔄</div>
          <h3 class="text-2xl font-bold">Sync Stores</h3>
          <p class="text-[var(--text-light)]">Multi-location support</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Seamlessly manage inventory across multiple store locations.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>
        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">📱</div>
          <h3 class="text-2xl font-bold">Barcode Scan</h3>
          <p class="text-[var(--text-light)]">Fast product lookup</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Scan barcodes instantly for quick and accurate product identification.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>
        <div class="feature-card" tabindex="0">
          <div class="feature-emoji">🔔</div>
          <h3 class="text-2xl font-bold">Alerts</h3>
          <p class="text-[var(--text-light)]">Never run out</p>
          <div class="feature-sep" aria-hidden="true"></div>
          <div class="feature-detail">
            <p>Get instant alerts when stock runs low to prevent stockouts.</p>
            <div class="feature-divider" aria-hidden="true"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Carousel -->
  <section id="testimonials" class="py-24 px-6 testimonials-bg">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-5xl md:text-5xl font-black mb-16">Loved by Business Owners</h2>

      <div class="relative">
        <!-- Arrows moved outside the box -->
        <button onclick="prevTestimonial()" class="absolute -left-16 top-1/2 -translate-y-1/2 z-10 text-5xl text-gray-300 hover:text-[var(--primary)] transition">←</button>
        <button onclick="nextTestimonial()" class="absolute -right-16 top-1/2 -translate-y-1/2 z-10 text-5xl text-gray-300 hover:text-[var(--primary)] transition">→</button>

        <div id="testimonialCard" class="rounded-3xl p-12 shadow-2xl mx-auto border-2 border-[var(--primary)] bg-transparent transition-all duration-300 testimonial-active" style="min-height: 350px; display: flex; flex-direction: column; justify-content: center; width: 95%; max-width: 900px;">
          <!-- Content will be populated by JavaScript -->
        </div>

        <!-- Made testimonial dots clickable -->
        <div class="flex justify-center gap-3 mt-8">
          <button onclick="goToTestimonial(0)" class="testimonial-dot w-3 h-3 rounded-full bg-gray-300 transition hover:bg-[var(--primary)]" style="cursor:pointer;"></button>
          <button onclick="goToTestimonial(1)" class="testimonial-dot w-3 h-3 rounded-full bg-gray-300 transition hover:bg-[var(--primary)]" style="cursor:pointer;"></button>
          <button onclick="goToTestimonial(2)" class="testimonial-dot w-3 h-3 rounded-full bg-gray-300 transition hover:bg-[var(--primary)]" style="cursor:pointer;"></button>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-24 px-6 faq-bg">
    <div class="max-w-4xl mx-auto text-center space-y-12">
      <h2 class="text-5xl md:text-5xl font-black">Frequently Asked Questions</h2>
      <p class="text-xl text-[var(--text-light)]">Everything you need to know about QuickPOS</p>

      <div class="space-y-6">
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>How quickly can I set up QuickPOS?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">Most businesses are up and running within 30 minutes. We provide step-by-step guidance and dedicated onboarding support.</div>
        </div>
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>What payment methods do you support?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">We support all major credit cards, digital wallets, bank transfers, and alternative payment methods. Integration with 100+ payment processors.</div>
        </div>
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>Is my data secure?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">Yes. We use 256-bit encryption, PCI DSS compliance, regular security audits, and automatic backups to ensure your data is always safe.</div>
        </div>
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>Can I integrate with my existing systems?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">Absolutely. QuickPOS integrates with 500+ apps including accounting software, inventory systems, and CRM platforms.</div>
        </div>
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>What's your uptime guarantee?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">We guarantee 99.9% uptime with 24/7 monitoring and instant failover systems.</div>
        </div>
        <div class="faq-item" onclick="toggleFAQ(this)">
          <div class="faq-question">
            <span>Do you offer mobile apps?</span>
            <span class="faq-arrow">▼</span>
          </div>
          <div class="faq-answer">Yes. iOS and Android apps with full functionality including offline mode for sales.</div>
        </div>
      </div>

      <div class="max-w-3xl mx-auto">
        <div class="glass rounded-3xl p-16 shadow-2xl border border-[var(--border)] text-center space-y-8">
          <h2 class="text-4xl md:text-4xl font-black">Still have questions?</h2>
          <p class="text-xl text-[var(--text-light)]">Our support team is here to help. Reach out anytime.</p>
          <a href="#contact" class="inline-block px-10 py-5 rounded-full btn-primary text-white font-bold text-lg shadow-xl hover:shadow-2xl transition">
            Contact Support
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing" class="py-24 px-6 pricing-bg">
    <div class="max-w-7xl mx-auto text-center space-y-8">
      <h2 class="text-5xl md:text-5xl font-black">Simple, Transparent Pricing</h2>
      <p class="text-xl text-[var(--text-light)]">Choose the perfect plan for your business</p>

      <div class="billing-toggle-wrap" style="display:flex;justify-content:center;gap:1rem;align-items:center;">
        <div id="billingMonthlyLabel" class="billing-label font-bold">Monthly</div>
        <label class="billing-toggle" title="Toggle billing" style="display:inline-block;">
          <input type="checkbox" id="billingToggle" onchange="toggleBilling()">
          <span class="billing-dot"></span>
        </label>
        <div id="billingAnnualLabel" class="billing-label">Annually <span class="billing-save">Save 20%</span></div>
      </div>

      <!-- Updated pricing card styling -->
      <div class="grid md:grid-cols-3 gap-10 max-w-5xl mx-auto pricing-grid">
        <!-- Basic -->
        <div id="basicCard" class="pricing-card pricing-card-basic" onclick="selectPlan('basic')">
          <div class="pricing-inner">
            <h3 class="pricing-title">Basic</h3>

            <div class="pricing-price-row">
              <span class="price-currency">$</span>
              <span class="price-amount">
                <span class="monthly-price">29</span>
                <span class="annual-price hidden">290</span>
              </span>
              <span class="price-period">
                <span class="monthly-price">/month</span>
                <span class="annual-price hidden">/year</span>
              </span>
            </div>

            <p class="pricing-sub text-[var(--text-light)] mb-8">Perfect for getting started</p>

            <button class="w-full py-4 rounded-2xl btn-primary text-white font-bold transition mb-8">Get Started</button>

            <ul class="space-y-4">
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Up to 5 users</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Basic inventory management</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Daily sales reports</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Email support</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>1 register</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Mobile app access</span></li>
            </ul>
          </div>
        </div>

        <!-- Pro (Popular) -->
        <div id="proCard" class="pricing-card pricing-card-pro popular" onclick="selectPlan('pro')">
          <div class="pricing-inner" style="position:relative;">
            <div class="pricing-badge">MOST POPULAR</div>

            <h3 class="pricing-title">Pro</h3>

            <div class="pricing-price-row">
              <span class="price-currency">$</span>
              <span class="price-amount">
                <span class="monthly-price">99</span>
                <span class="annual-price hidden">990</span>
              </span>
              <span class="price-period">
                <span class="monthly-price">/month</span>
                <span class="annual-price hidden">/year</span>
              </span>
            </div>

            <p class="pricing-sub text-[var(--text-light)] mb-8">For growing businesses</p>

            <button class="w-full py-4 rounded-2xl btn-primary text-white font-bold transition mb-8">Get Started</button>

            <ul class="space-y-4">
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Up to 50 users</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Advanced inventory management</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Real-time analytics</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Priority support</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>10 registers</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Custom integrations</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Multi-location support</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>API access</span></li>
            </ul>
          </div>
        </div>

        <!-- Enterprise -->
        <div id="enterpriseCard" class="pricing-card pricing-card-enterprise" onclick="selectPlan('enterprise')">
          <div class="pricing-inner">
            <h3 class="pricing-title">Enterprise</h3>

            <div class="pricing-price-row">
              <span class="price-currency">$</span>
              <span class="price-amount">
                <span class="monthly-price">299</span>
                <span class="annual-price hidden">2990</span>
              </span>
              <span class="price-period">
                <span class="monthly-price">/month</span>
                <span class="annual-price hidden">/year</span>
              </span>
            </div>

            <p class="pricing-sub text-[var(--text-light)] mb-8">For large organizations</p>

            <button class="w-full py-4 rounded-2xl btn-primary text-white font-bold transition mb-8">Get Started</button>

            <ul class="space-y-4">
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Unlimited users</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Full customization</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>24/7 dedicated support</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Unlimited registers</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>API access</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>White‑label options</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>On‑premise deployment</span></li>
              <li class="flex items-start gap-3"><span class="check text-[var(--primary)]">✓</span><span>Advanced security & compliance</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="py-32 px-6 contact-bg">
    <div class="max-w-2xl mx-auto text-center space-y-12">
      <h2 class="text-5xl md:text-5xl font-black">Get in Touch</h2>
      <p class="text-xl text-[var(--text-light)]">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

      <form action="contact.php" method="POST" class="space-y-8">
        <div class="contact-form-group">
          <label for="name" class="contact-label">Name</label>
          <input type="text" id="name" name="name" placeholder="John Doe" required class="contact-input">
        </div>
        <div class="contact-form-group">
          <label for="email" class="contact-label">Email</label>
          <input type="email" id="email" name="email" placeholder="john@example.com" required class="contact-input">
        </div>
        <div class="contact-form-group">
          <label for="message" class="contact-label">Message</label>
          <textarea id="message" name="message" rows="6" placeholder="Tell us how we can help..." required class="contact-input resize-none"></textarea>
        </div>
        <button type="submit" class="w-full py-5 rounded-full btn-primary text-white font-bold text-xl shadow-xl">
          Send Message
        </button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-20 px-6 border-t border-[var(--border)] footer-bg">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12 text-center md:text-left mb-12">
      <div>
        <div class="flex items-center justify-center md:justify-start gap-3 mb-6">
          <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] text-white font-bold text-2xl flex items-center justify-center shadow-lg">
            <i class="fas fa-cash-register"></i>
          </div>
          <span class="text-2xl font-bold bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] bg-clip-text text-transparent">QuickPOS</span>
        </div>
        <p class="text-[var(--text-light)]">The modern point of sale system for growing businesses worldwide.</p>
      </div>
      <div><h4 class="font-bold mb-4">Product</h4><ul class="space-y-2 text-[var(--text-light)]"><li><a href="#features" class="hover:text-[var(--primary)] transition">Features</a></li><li><a href="#pricing" class="hover:text-[var(--primary)] transition">Pricing</a></li><li><a href="#" class="hover:text-[var(--primary)] transition">Security</a></li><li><a href="#" class="hover:text-[var(--primary)] transition">Changelog</a></li></ul></div>
      <div><h4 class="font-bold mb-4">Company</h4><ul class="space-y-2 text-[var(--text-light)]"><li><a href="#" class="hover:text-[var(--primary)] transition">About</a></li><li><a href="#" class="hover:text-[var(--primary)] transition">Blog</a></li><li><a href="#" class="hover:text-[var(--primary)] transition">Careers</a></li><li><a href="#contact" class="hover:text-[var(--primary)] transition">Contact</a></li></ul></div>
      <div><h4 class="font-bold mb-4">Follow Us</h4><div class="flex justify-center md:justify-start gap-6 text-2xl text-[var(--text-light)]">
        <a href="#" class="hover:text-[var(--primary)] transition" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="hover:text-[var(--primary)] transition" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" class="hover:text-[var(--primary)] transition" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="hover:text-[var(--primary)] transition" title="YouTube"><i class="fab fa-youtube"></i></a>
      </div></div>
    </div>
    <div class="border-t border-[var(--border)] pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-[var(--text-light)]">
      <div>© 2025 QuickPOS. All rights reserved. Privacy matters.</div>
      <div class="flex gap-6 text-sm">
        <a href="#" class="hover:text-[var(--primary)] transition">Privacy Policy</a>
        <a href="#" class="hover:text-[var(--primary)] transition">Terms of Service</a>
        <a href="#" class="hover:text-[var(--primary)] transition">Cookie Policy</a>
      </div>
    </div>
  </footer>

  <!-- Multi-step Sign Up Modal -->
  <dialog id="signupModal" class="glass rounded-3xl p-10 max-w-lg w-full shadow-2xl">
    <button onclick="closeSignup()" style="position:absolute;top:20px;right:20px;background:none;border:none;font-size:2rem;cursor:pointer;color:#9ca3af;hover:color:#6b7280;">×</button>
    
    <div class="text-center space-y-8">
      <h3 class="text-3xl font-bold">Get Started Free</h3>
      <p class="text-[var(--text-light)]">Join 10,000+ businesses using QuickPOS</p>

      <!-- Progress Bars -->
      <div class="signup-progress">
        <div class="signup-progress-bar"></div>
        <div class="signup-progress-bar inactive"></div>
        <div class="signup-progress-bar inactive"></div>
      </div>

      <!-- Step 1: Email & Company -->
      <div class="signup-step active">
        <div class="space-y-4">
          <input type="email" id="email1" placeholder="Email Address" class="w-full px-6 py-4 rounded-2xl border border-[var(--border)] focus:border-[var(--primary)] focus:ring-4 focus:ring-[var(--primary)]/20 transition">
          <input type="text" id="company" placeholder="Company Name" class="w-full px-6 py-4 rounded-2xl border border-[var(--border)] focus:border-[var(--primary)] focus:ring-4 focus:ring-[var(--primary)]/20 transition">
        </div>
      </div>

      <!-- Step 2: Password -->
      <div class="signup-step">
        <div class="space-y-4">
          <input type="password" id="password" placeholder="Password" class="w-full px-6 py-4 rounded-2xl border border-[var(--border)] focus:border-[var(--primary)] focus:ring-4 focus:ring-[var(--primary)]/20 transition">
          <p class="text-sm text-[var(--text-light)]">At least 8 characters with uppercase, lowercase, and numbers</p>
        </div>
      </div>

      <!-- Step 3: Success -->
      <div class="signup-step">
        <div class="space-y-4 text-center">
          <div style="font-size:4rem;">✓</div>
          <h4 class="text-2xl font-bold">You're all set!</h4>
          <p class="text-[var(--text-light)]">Check your email to verify your account</p>
        </div>
      </div>

      <p class="text-sm text-[var(--text-light)]">By signing up, you agree to our Terms of Service</p>

      <!-- Action Buttons -->
      <div class="signup-buttons">
        <button onclick="previousStep()" class="signup-button-back" style="display:none;" id="backBtn">Back</button>
        <button onclick="nextStep()" class="signup-button-next" id="nextBtn">Next</button>
      </div>
    </div>
  </dialog>

  <script>
    // Tabs
    document.getElementById('salesTab').onclick = () => {
      document.getElementById('salesFeatures').classList.remove('hidden');
      document.getElementById('inventoryFeatures').classList.add('hidden');
      document.getElementById('salesTab').classList.add('pill-active');
      document.getElementById('salesTab').classList.remove('bg-white/80', 'border', 'border-gray-200', 'text-[var(--text)]');
      document.getElementById('inventoryTab').classList.remove('pill-active');
      document.getElementById('inventoryTab').classList.add('bg-white/80', 'border', 'border-gray-200', 'text-[var(--text)]');
    };
    
    document.getElementById('inventoryTab').onclick = () => {
      document.getElementById('inventoryFeatures').classList.remove('hidden');
      document.getElementById('salesFeatures').classList.add('hidden');
      document.getElementById('inventoryTab').classList.add('pill-active');
      document.getElementById('inventoryTab').classList.remove('bg-white/80', 'border', 'border-gray-200', 'text-[var(--text)]');
      document.getElementById('salesTab').classList.remove('pill-active');
      document.getElementById('salesTab').classList.add('bg-white/80', 'border', 'border-gray-200', 'text-[var(--text)]');
    };

    function toggleBilling() {
      const isAnnual = document.getElementById('billingToggle').checked;
      document.querySelectorAll('.monthly-price').forEach(el => el.classList.toggle('hidden', isAnnual));
      document.querySelectorAll('.annual-price').forEach(el => el.classList.toggle('hidden', !isAnnual));
      const mLabel = document.getElementById('billingMonthlyLabel');
      const aLabel = document.getElementById('billingAnnualLabel');
      if (mLabel && aLabel) {
        mLabel.classList.toggle('font-bold', !isAnnual);
        aLabel.classList.toggle('font-bold', isAnnual);
      }
    }

    const testimonials = [
      { 
        icon: "👩‍💼", 
        name: "Sonia", 
        title: "CEO at TechStore", 
        text: "QuickPOS transformed our retail operations. Sales increased by 40% in the first month!",
        stars: "★★★★★"
      },
      { 
        icon: "👨‍💼", 
        name: "Michael Chen", 
        title: "Manager at FreshMart", 
        text: "The best POS system we've ever used. Support is incredible and the interface is intuitive.",
        stars: "★★★★★"
      },
      { 
        icon: "👨‍🍳", 
        name: "Aleena", 
        title: "Owner at Café Bliss", 
        text: "Inventory management has never been easier. We save 5 hours per week on admin work.",
        stars: "★★★★★"
      }
    ];
    let currentTestimonial = 0;

    function updateTestimonial() {
      const t = testimonials[currentTestimonial];
      const testimonialCard = document.getElementById('testimonialCard');
      
      testimonialCard.innerHTML = `
        <div class="text-8xl mb-8 testimonial-emoji transition-transform duration-300">${t.icon}</div>
        <p class="text-3xl font-bold leading-relaxed mb-8">"${t.text}"</p>
        <div class="text-yellow-500 text-4xl mb-8">${t.stars}</div>
        <p class="text-xl font-bold">${t.name}</p>
        <p class="text-[var(--text-light)]">${t.title}</p>
      `;
      
      // Add active class to apply hover effects
      testimonialCard.classList.add('testimonial-active');
      
      // Update dot styles
      document.querySelectorAll('.testimonial-dot').forEach((dot, idx) => {
        if (idx === currentTestimonial) {
          dot.style.background = 'linear-gradient(90deg, var(--primary), var(--accent))';
        } else {
          dot.style.background = '#d1d5db';
        }
      });
    }

    function goToTestimonial(index) {
      currentTestimonial = index;
      updateTestimonial();
    }

    function nextTestimonial() {
      currentTestimonial = (currentTestimonial + 1) % testimonials.length;
      updateTestimonial();
    }

    function prevTestimonial() {
      currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
      updateTestimonial();
    }

    let signupStep = 1;

    function openSignup() {
      document.getElementById('signupModal').showModal();
      signupStep = 1;
      updateSignupUI();
    }

    function closeSignup() {
      document.getElementById('signupModal').close();
      signupStep = 1;
    }

    function nextStep() {
      if (signupStep === 1) {
        const email = document.getElementById('email1').value;
        const company = document.getElementById('company').value;
        if (!email || !company) {
          alert('Please fill all fields');
          return;
        }
        signupStep = 2;
      } else if (signupStep === 2) {
        const password = document.getElementById('password').value;
        if (!password || password.length < 8) {
          alert('Password must be at least 8 characters');
          return;
        }
        signupStep = 3;
      } else if (signupStep === 3) {
        closeSignup();
        return;
      }
      updateSignupUI();
    }

    function previousStep() {
      if (signupStep > 1) {
        signupStep--;
        updateSignupUI();
      }
    }

    function updateSignupUI() {
      document.querySelectorAll('.signup-step').forEach((step, idx) => {
        step.classList.toggle('active', idx + 1 === signupStep);
      });

      document.querySelectorAll('.signup-progress-bar').forEach((bar, idx) => {
        bar.classList.toggle('inactive', idx + 1 > signupStep);
      });

      document.getElementById('backBtn').style.display = signupStep > 1 ? 'block' : 'none';
      
      const nextBtn = document.getElementById('nextBtn');
      if (signupStep === 3) {
        nextBtn.textContent = 'Get Started';
      } else {
        nextBtn.textContent = 'Next';
      }
    }

    document.addEventListener('DOMContentLoaded', function(){
      toggleBilling();
      updateTestimonial();
      updateSignupUI(); // Ensure initial UI state is correct
      
      const dashboardBtns = document.querySelectorAll('.dashboard-btn');
      dashboardBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function(){
          this.style.fill = 'var(--primary)';
          this.style.filter = 'brightness(1.1)';
          this.style.boxShadow = '0 0 16px rgba(67, 97, 238, 0.4)';
        });
        btn.addEventListener('mouseleave', function(){
          this.style.fill = '#e0fcf8';
          this.style.filter = 'none';
          this.style.boxShadow = 'none';
        });
      });
    });

    function selectPlan(plan) {
      document.querySelectorAll('.pricing-card').forEach(card => {
        card.classList.remove('active');
      });
      document.getElementById(`${plan}Card`).classList.add('active');
    }

    function toggleFAQ(item) {
      // Close other FAQ items
      document.querySelectorAll('.faq-item').forEach(faq => {
        if (faq !== item && faq.classList.contains('active')) {
          faq.classList.remove('active');
        }
      });
      
      // Toggle current item
      item.classList.toggle('active');
    }

    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        e.preventDefault();
        document.querySelector(a.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
      });
    });
  </script>
</body>
</html>
