@extends('layouts.app')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

<style>
:root {
  --a:     #6c47ff;
  --a2:    #a78bfa;
  --a3:    #38bdf8;
  --ink:   #111827;
  --ink2:  #374151;
  --muted: #6b7280;
  --panel: #eef0ff;
  --card:  #ffffff;
  --border:#e5e7eb;
  --ease-spring: cubic-bezier(0.34,1.56,0.64,1);
  --ease-out:    cubic-bezier(0.22,1,0.36,1);
  --f-head: 'Bricolage Grotesque', sans-serif;
  --f-body: 'Outfit', sans-serif;
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

body {
  font-family: var(--f-body);
  /* ★ LIGHT PURPLE background */
  background: #f0eeff;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 28px 16px;
  position: relative;
  overflow: hidden;
}

/* ── Static light purple radial wash ── */
body::after {
  content: '';
  position: fixed; inset: 0;
  background:
    radial-gradient(ellipse 70% 60% at 15% 20%,  rgba(108,71,255,.12) 0%, transparent 60%),
    radial-gradient(ellipse 60% 55% at 85% 75%,  rgba(167,139,250,.10) 0%, transparent 60%),
    radial-gradient(ellipse 50% 50% at 50% 50%,  rgba(56,189,248,.06)  0%, transparent 65%);
  pointer-events: none;
  z-index: 0;
  animation: bgWash 16s ease-in-out infinite alternate;
}
@keyframes bgWash {
  from { opacity:.7; }
  to   { opacity:1; transform:scale(1.04); }
}

/* ════════════════════════════════════════
   GLOWING FRAME WRAPPER
   — the rotating conic-gradient border
════════════════════════════════════════ */
.auth-glow-wrap {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 984px;   /* 980 + 4px padding */
  border-radius: 30px;
  padding: 3px;       /* space for the glow border */

  /* The animated conic gradient that spins */
  background: conic-gradient(
    from var(--angle, 0deg),
    var(--a3)   0%,
    var(--a)    20%,
    var(--a2)   40%,
    #ffffff     50%,
    var(--a2)   60%,
    var(--a)    80%,
    var(--a3)   100%
  );
  animation: spinBorder 4s linear infinite, glowPulse 3s ease-in-out infinite alternate;

  /* Outer glow */
  box-shadow:
    0 0 0   3px rgba(108,71,255,.18),
    0 0 30px 6px rgba(108,71,255,.22),
    0 0 60px 12px rgba(108,71,255,.12),
    0 20px 60px rgba(108,71,255,.18),
    0 8px 24px rgba(0,0,0,.12);
}

/* CSS custom property trick for conic rotation */
@property --angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}
@keyframes spinBorder {
  to { --angle: 360deg; }
}
@keyframes glowPulse {
  from {
    box-shadow:
      0 0 0   3px rgba(108,71,255,.15),
      0 0 25px 5px rgba(108,71,255,.20),
      0 0 55px 10px rgba(108,71,255,.10),
      0 20px 60px rgba(108,71,255,.15),
      0 8px 24px rgba(0,0,0,.10);
  }
  to {
    box-shadow:
      0 0 0   3px rgba(56,189,248,.25),
      0 0 40px 10px rgba(108,71,255,.35),
      0 0 80px 20px rgba(108,71,255,.18),
      0 20px 60px rgba(108,71,255,.25),
      0 8px 24px rgba(0,0,0,.14);
  }
}

/* ════════════════════════════════════════
   OUTER CARD  — sits inside the glow wrap
════════════════════════════════════════ */
.auth-frame {
  position: relative;
  z-index: 1;
  display: grid;
  grid-template-columns: 1.05fr 1fr;
  width: 100%;
  min-height: 620px;
  border-radius: 27px;   /* slightly less than wrap */
  overflow: hidden;
  animation: frameIn 0.85s var(--ease-out) both;
}
@keyframes frameIn {
  from { opacity:0; transform:translateY(32px) scale(0.96); }
  to   { opacity:1; transform:translateY(0)    scale(1); }
}

/* ════════════════════════════════════════
   LEFT — VISUAL (light panel)
════════════════════════════════════════ */
.auth-visual {
  position: relative;
  background: var(--panel);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 52px 40px 40px;
  overflow: hidden;
}
.auth-visual::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 100% 60% at 10% 0%,  rgba(108,71,255,.13) 0%, transparent 55%),
    radial-gradient(ellipse 70%  70% at 90% 90%, rgba(56,189,248,.10) 0%, transparent 55%),
    radial-gradient(ellipse 60%  50% at 50% 50%, rgba(167,139,250,.08) 0%, transparent 60%);
  animation: washDrift 14s ease-in-out infinite alternate;
  pointer-events: none;
}
@keyframes washDrift {
  from { opacity:.7; }
  to   { opacity:1; transform:scale(1.05); }
}

/* moving dot-grid */
.av-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(108,71,255,.22) 1.4px, transparent 1.4px);
  background-size: 26px 26px;
  pointer-events: none;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 75%);
  animation: gridPan 30s linear infinite;
}
@keyframes gridPan {
  from { background-position:0 0; }
  to   { background-position:26px 26px; }
}

/* rings */
.av-ring { position:absolute; border-radius:50%; border:1px solid; pointer-events:none; }
.av-ring-1 { width:280px;height:280px; top:-100px;left:-100px; border-color:rgba(108,71,255,.15); animation:ringPulse 6s ease-in-out infinite; }
.av-ring-2 { width:200px;height:200px; top:-60px; left:-60px;  border-color:rgba(108,71,255,.10); animation:ringPulse 6s ease-in-out infinite 1.5s; }
.av-ring-3 { width:220px;height:220px; bottom:-80px;right:-80px; border-color:rgba(56,189,248,.12); animation:ringPulse 6s ease-in-out infinite 3s; }
@keyframes ringPulse {
  0%,100%{transform:scale(1);opacity:.5;}
  50%    {transform:scale(1.1);opacity:1;}
}

/* sparkles */
.av-sparkle { position:absolute; width:5px;height:5px; border-radius:50%; pointer-events:none; }
.av-sparkle::before,.av-sparkle::after { content:''; position:absolute; background:var(--a); border-radius:2px; }
.av-sparkle::before { width:2px;height:10px; left:50%;transform:translateX(-50%); }
.av-sparkle::after  { width:10px;height:2px; top:50%;transform:translateY(-50%); }
.sp1{top:18%;left:10%;animation:sparkle 5s ease-in-out infinite;}
.sp2{top:12%;right:14%;animation:sparkle 7s ease-in-out infinite 1s;}
.sp3{bottom:22%;left:8%;animation:sparkle 6s ease-in-out infinite 2s;}
.sp4{bottom:15%;right:10%;animation:sparkle 5.5s ease-in-out infinite .5s;}
.sp5{top:45%;left:5%;animation:sparkle 8s ease-in-out infinite 3s;}
@keyframes sparkle {
  0%,100%{transform:translateY(0) rotate(0) scale(1);opacity:.55;}
  33%    {transform:translateY(-12px) rotate(45deg) scale(1.3);opacity:1;}
  66%    {transform:translateY(6px) rotate(-15deg) scale(.9);opacity:.35;}
}

/* live pill */
.av-live-pill {
  position:absolute; top:20px;right:20px; z-index:5;
  display:flex;align-items:center;gap:7px;
  padding:6px 14px;
  background:rgba(255,255,255,.85); backdrop-filter:blur(12px);
  border:1px solid rgba(108,71,255,.18); border-radius:100px;
  font-size:.7rem;font-weight:500;color:var(--ink2);
  letter-spacing:1.5px;text-transform:uppercase;
  box-shadow:0 4px 16px rgba(108,71,255,.1);
  animation:pillIn .8s var(--ease-spring) .3s both;
}
@keyframes pillIn {
  from{opacity:0;transform:translateY(-10px) scale(.9);}
  to  {opacity:1;transform:translateY(0) scale(1);}
}
.av-live-dot {
  width:7px;height:7px;background:#22c55e;border-radius:50%;flex-shrink:0;
  animation:livePulse 2s ease infinite;
}
@keyframes livePulse {
  0%  {box-shadow:0 0 0 0   rgba(34,197,94,.5);}
  70% {box-shadow:0 0 0 8px rgba(34,197,94,0);}
  100%{box-shadow:0 0 0 0   rgba(34,197,94,0);}
}

/* tilt + image */
.av-tilt-wrap {
  position:relative; z-index:3;
  transform-style:preserve-3d;
  transition:transform .12s ease;
}
.av-glow-orb {
  position:absolute; width:280px;height:280px;
  top:50%;left:50%;transform:translate(-50%,-50%);
  background:radial-gradient(circle,rgba(108,71,255,.16) 0%,transparent 70%);
  border-radius:50%;filter:blur(22px);
  animation:orbBreath 4s ease-in-out infinite;pointer-events:none;
}
@keyframes orbBreath {
  0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.7;}
  50%    {transform:translate(-50%,-50%) scale(1.15);opacity:1;}
}
.av-img {
  position:relative;z-index:2;
  width:300px;height:300px;object-fit:contain;
  animation:imgFloat 7s ease-in-out infinite;
  filter:drop-shadow(0 20px 40px rgba(108,71,255,.18));
}
@keyframes imgFloat {
  0%,100%{transform:translateY(0) rotate3d(0,1,0,0deg);}
  50%    {transform:translateY(-16px) rotate3d(0,1,0,2deg);}
}

/* ════════════════════════════════════════
   RIGHT — FORM  (WHITE)
════════════════════════════════════════ */
.auth-form-side {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 52px 48px;
  background: var(--card);
  direction: ltr !important;
  text-align: left !important;
  unicode-bidi: isolate !important;
}

/* top shimmer line */
.auth-form-side::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, transparent, var(--a), var(--a3), transparent);
  animation: shimmerLine 4s ease-in-out infinite;
}
@keyframes shimmerLine {
  0%,100%{opacity:.5;}
  50%    {opacity:1;}
}

/* subtle mesh accent */
.form-mesh {
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    linear-gradient(rgba(108,71,255,.04) 1px, transparent 1px),
    linear-gradient(90deg,rgba(108,71,255,.04) 1px, transparent 1px);
  background-size: 40px 40px;
  mask-image: radial-gradient(ellipse 55% 55% at 100% 0%, black 0%, transparent 70%);
  animation: meshScroll 20s linear infinite;
}
@keyframes meshScroll {
  from{background-position:0 0;}
  to  {background-position:40px 40px;}
}

/* staggered entrance */
.auth-form-side > *,
.auth-form-side form > * {
  animation: itemReveal .65s var(--ease-out) both;
}
.auth-form-side > *:nth-child(1){animation-delay:.18s;}
.auth-form-side > *:nth-child(2){animation-delay:.25s;}
.auth-form-side > *:nth-child(3){animation-delay:.32s;}
.auth-form-side > *:nth-child(4){animation-delay:.39s;}
.auth-form-side > *:nth-child(5){animation-delay:.46s;}
.auth-form-side form > *:nth-child(1){animation-delay:.44s;}
.auth-form-side form > *:nth-child(2){animation-delay:.51s;}
.auth-form-side form > *:nth-child(3){animation-delay:.58s;}
.auth-form-side form > *:nth-child(4){animation-delay:.65s;}
@keyframes itemReveal {
  from{opacity:0;transform:translateX(22px);}
  to  {opacity:1;transform:translateX(0);}
}

/* ── Badge ── */
.auth-badge {
  position: relative; z-index: 1;
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px 5px 10px;
  background: rgba(108,71,255,.08);
  border: 1px solid rgba(108,71,255,.22);
  border-radius: 100px;
  font-size: .68rem; font-weight: 500; color: var(--a);
  letter-spacing: 2px; text-transform: uppercase;
  margin-bottom: 20px; width: fit-content;
}
.auth-badge-dot {
  width:6px;height:6px;background:var(--a);border-radius:50%;
  animation:livePulse 2s ease infinite;
}

/* ── Title ── */
.auth-title {
  position: relative; z-index: 1;
  font-family: var(--f-head) !important;
  font-size: 2.2rem !important;
  font-weight: 800 !important;
  color: var(--ink) !important;
  line-height: 1.1 !important;
  letter-spacing: -1.4px !important;
  margin-bottom: 9px !important;
  direction: ltr !important;
  text-align: left !important;
}
.auth-title em {
  font-style: normal;
  background: linear-gradient(135deg, var(--a), var(--a3));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.auth-sub {
  position: relative; z-index: 1;
  font-size: .9rem; color: var(--muted);
  font-weight: 300; line-height: 1.65;
  margin-bottom: 34px;
  direction: ltr !important; text-align: left !important;
}

/* ── Fields ── */
.field-group {
  position: relative; z-index: 1;
  margin-bottom: 16px;
  direction: ltr !important;
}
.field-label {
  display: block;
  font-size: .72rem; font-weight: 500;
  color: #374151; letter-spacing: .8px;
  text-transform: uppercase; margin-bottom: 7px;
  text-align: left !important;
  transition: color .25s;
}
.field-wrap {
  position: relative; direction: ltr;
}
.field-wrap::after {
  content: '';
  position: absolute; inset: -1.5px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--a), var(--a3));
  z-index: 0; opacity: 0;
  transition: opacity .3s ease;
  pointer-events: none;
}
.field-wrap:focus-within::after { opacity: 1; }
.field-icon {
  position: absolute;
  left: 15px; top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  pointer-events: none;
  transition: color .3s ease, transform .3s var(--ease-spring);
  z-index: 2;
  display: flex; align-items: center;
  width: 18px; height: 18px;
}
.field-wrap:focus-within .field-icon {
  color: var(--a);
  transform: translateY(-50%) scale(1.15);
}
.field-wrap input {
  position: relative; z-index: 1;
  width: 100%; height: 52px;
  padding: 0 16px 0 44px;
  font-family: var(--f-body);
  font-size: .92rem;
  color: var(--ink);
  background: #f9fafb;
  border: 1.5px solid var(--border);
  border-radius: 13px;
  outline: none;
  transition: background .25s, border-color .25s, box-shadow .25s;
  direction: ltr; text-align: left;
  caret-color: var(--a);
}
.field-wrap input::placeholder { color: #d1d5db; }
.field-wrap input:focus {
  background: #fff;
  border-color: transparent;
  box-shadow: 0 0 0 3.5px rgba(108,71,255,.13);
}
.field-wrap input.has-eye { padding-right: 48px; }

/* ── Eye toggle ── */
.eye-btn {
  position: absolute;
  right: 13px; top: 50%;
  transform: translateY(-50%);
  z-index: 3;
  background: none;
  border: none;
  cursor: pointer;
  color: #6b7280;
  padding: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  transition: color .2s, background .2s;
  line-height: 1;
}
.eye-btn:hover {
  color: var(--a);
  background: rgba(108,71,255,.08);
}
.eye-btn svg { display: block; flex-shrink: 0; }

/* ── Options row ── */
.auth-options {
  position: relative; z-index: 1;
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 24px;
  direction: ltr !important;
}
.remember-wrap {
  display: flex; align-items: center; gap: 9px;
  cursor: pointer; user-select: none;
}
.remember-wrap input[type="checkbox"] { display: none; }
.cb {
  width: 19px; height: 19px;
  border: 1.5px solid #d1d5db; border-radius: 6px;
  background: white;
  display: grid; place-items: center; flex-shrink: 0;
  transition: all .25s var(--ease-spring);
}
.cb svg {
  width: 10px; height: 10px;
  stroke: white; stroke-width: 2.5;
  stroke-linecap: round; stroke-linejoin: round; fill: none;
  opacity: 0; transform: scale(.3) rotate(-10deg);
  transition: all .25s var(--ease-spring);
}
.remember-wrap input:checked ~ .cb {
  background: linear-gradient(135deg, var(--a), #8b68ff);
  border-color: transparent;
  box-shadow: 0 4px 14px rgba(108,71,255,.4);
}
.remember-wrap input:checked ~ .cb svg { opacity:1; transform:scale(1) rotate(0deg); }
.remember-text { font-size:.83rem; color:#4b5563; }




/* ── Submit button ── */
.btn-wrap { position:relative; z-index:1; }
.btn-submit {
  position: relative;
  width: 100%; height: 54px;
  border: none; border-radius: 13px;
  background: linear-gradient(135deg, var(--a) 0%, #8b68ff 50%, var(--a3) 100%);
  background-size: 200% 200%;
  color: white;
  font-family: var(--f-head);
  font-size: .95rem; font-weight: 700; letter-spacing: .3px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 10px;
  transition: all .4s var(--ease-out);
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(108,71,255,.38), 0 1px 4px rgba(0,0,0,.12);
  animation: gradShift 4s ease infinite;
}
@keyframes gradShift {
  0%  {background-position:0%   50%;}
  50% {background-position:100% 50%;}
  100%{background-position:0%   50%;}
}
.btn-submit::before {
  content:''; position:absolute;
  top:0;left:-100%;width:60%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);
  transition:left .5s ease;
}
.btn-submit:hover {
  box-shadow:0 8px 36px rgba(108,71,255,.55),0 2px 8px rgba(56,189,248,.25);
  transform:translateY(-3px) scale(1.01);
}
.btn-submit:hover::before { left:150%; }
.btn-submit:hover .btn-arrow-ring {
  transform:translateX(5px) rotate(-20deg);
  background:rgba(255,255,255,.3);
}
.btn-submit:active { transform:translateY(-1px) scale(.99); }
.btn-arrow-ring {
  width:28px;height:28px;
  background:rgba(255,255,255,.2); border-radius:8px;
  display:grid;place-items:center;flex-shrink:0;
  transition:transform .3s var(--ease-spring), background .3s;
}

/* ── Footer note ── */
.auth-foot {
  position: relative; z-index: 1;
  margin-top: 22px;
  display: flex; align-items: center; justify-content: center; gap: 7px;
  font-size: .73rem; color: #9ca3af;
  direction: ltr !important;
  transition: color .3s;
}
.auth-foot:hover { color: #6b7280; }

/* ════════════════════════════════════════
   RESPONSIVE
════════════════════════════════════════ */
@media (max-width:768px) {
  .auth-glow-wrap  { max-width: 440px; padding: 3px; }
  .auth-frame      { grid-template-columns:1fr; min-height:auto; }
  .auth-visual     { display:none; }
  .auth-form-side  { padding:44px 28px; }
  body             { overflow:auto; }
}
@media (max-width:480px) {
  .auth-form-side  { padding:36px 20px; }
  .auth-title      { font-size:1.9rem !important; }
}
</style>
@vite(['resources/scss/light/assets/authentication/auth-cover.scss'])
@vite(['resources/scss/dark/assets/authentication/auth-cover.scss'])
@endsection


@section('content')






<div class="auth-glow-wrap">
  <div class="auth-frame">

    {{-- ════════ LEFT — Visual ════════ --}}
    <div class="auth-visual" id="authVisual">
        <div class="av-grid"></div>
        <div class="av-ring av-ring-1"></div>
        <div class="av-ring av-ring-2"></div>
        <div class="av-ring av-ring-3"></div>
        <div class="av-sparkle sp1"></div>
        <div class="av-sparkle sp2"></div>
        <div class="av-sparkle sp3"></div>
        <div class="av-sparkle sp4"></div>
        <div class="av-sparkle sp5"></div>



        <div class="av-tilt-wrap" id="tiltWrap">
            <div class="av-glow-orb"></div>
            <img class="av-img" src="{{ asset('images/background.png') }}" alt="Dashboard">
        </div>
    </div>

    {{-- ════════ RIGHT — Form ════════ --}}
    <div class="auth-form-side">



        <div class="form-mesh"></div>

        <div class="auth-badge">
            <span class="auth-badge-dot"></span>
            SERVIXA
        </div>

        <h1 class="auth-title">Welcome back <em>Admin!</em></h1>
        <p class="auth-sub">Enter your email and password to access<br>your dashboard.</p>

        <form action="{{ route('login.submit') }}" method="POST" id="loginForm">
            @csrf

            {{-- Email --}}
<div class="field-group @error('email') field-error @enderror">
    <label class="field-label" for="loginEmail">Email Address</label>
    <div class="field-wrap">
        <span class="field-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="3"/>
                <polyline points="2,4 12,13 22,4"/>
            </svg>
        </span>
        <input type="email" id="loginEmail" name="email"
               value="{{ old('email') }}"
               placeholder="example@gmail.com"
               autocomplete="email" required
               @error('email') aria-invalid="true" @enderror>
    </div>
    @error('email')
        <span class="error-message">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <circle cx="12" cy="16" r="1" fill="currentColor"/>
            </svg>
            {{ $message }}
        </span>
    @enderror
</div>

            {{-- Password --}}
<div class="field-group @error('password') field-error @enderror">
    <label class="field-label" for="loginPassword">Password</label>
    <div class="field-wrap">
        <span class="field-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="11" width="14" height="10" rx="2"/>
                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
            </svg>
        </span>
        <input type="password" id="loginPassword" name="password"
               placeholder="••••••••••"
               autocomplete="current-password"
               class="has-eye" required
               @error('password') aria-invalid="true" @enderror>
        <button type="button" class="eye-btn" id="eyeToggle"
                aria-label="Show or hide password">
            <svg id="iconEyeOpen" width="18" height="18" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <svg id="iconEyeClosed" style="display:none"
                 width="18" height="18" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
        </button>
    </div>
    @error('password')
        <span class="error-message">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <circle cx="12" cy="16" r="1" fill="currentColor"/>
            </svg>
            {{ $message }}
        </span>
    @enderror
</div>

            {{-- Options --}}
            <div class="auth-options">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" id="rememberMe" checked>
                    <div class="cb">
                        <svg viewBox="0 0 12 10"><polyline points="1 5 4.5 8.5 11 1"/></svg>
                    </div>
                    <span class="remember-text">Keep me signed in</span>
                </label>
            </div>

            {{-- Submit --}}
            <div class="btn-wrap">
                <button type="submit" class="btn-submit" id="btnSubmit">
                    Sign In
                    <span class="btn-arrow-ring">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </span>
                </button>
            </div>
        </form>

        <p class="auth-foot">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Protected by 256-bit SSL encryption
        </p>
    </div>

  </div>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── 1. TILT EFFECT ── */
    const visual   = document.getElementById('authVisual');
    const tiltWrap = document.getElementById('tiltWrap');
    visual?.addEventListener('mousemove', e => {
        const r = visual.getBoundingClientRect();
        const x = ((e.clientX-r.left)/r.width  - .5) * 14;
        const y = ((e.clientY-r.top) /r.height - .5) * -14;
        tiltWrap.style.transform = `perspective(600px) rotateY(${x}deg) rotateX(${y}deg)`;
    });
    visual?.addEventListener('mouseleave', () => {
        tiltWrap.style.transform = 'perspective(600px) rotateY(0) rotateX(0)';
    });

    /* ── 2. MAGNETIC BUTTON ── */
    const btn = document.getElementById('btnSubmit');
    btn?.addEventListener('mousemove', e => {
        const r  = btn.getBoundingClientRect();
        const dx = (e.clientX-(r.left+r.width/2))  * .22;
        const dy = (e.clientY-(r.top +r.height/2)) * .22;
        btn.style.transform = `translate(${dx}px,${dy}px) translateY(-3px) scale(1.01)`;
    });
    btn?.addEventListener('mouseleave', () => { btn.style.transform = ''; });

    /* ── 3. CLICK RIPPLE ── */
    btn?.addEventListener('click', e => {
        const r = btn.getBoundingClientRect();
        const s = Math.max(r.width,r.height)*2;
        const rpl = document.createElement('span');
        rpl.style.cssText = `position:absolute;width:${s}px;height:${s}px;
            top:${e.clientY-r.top-s/2}px;left:${e.clientX-r.left-s/2}px;
            background:rgba(255,255,255,0.25);border-radius:50%;
            transform:scale(0);pointer-events:none;
            animation:rippleAnim .6s ease-out forwards;`;
        btn.appendChild(rpl);
        setTimeout(()=>rpl.remove(),660);
    });
    if(!document.getElementById('rippleKF')){
        const st=document.createElement('style');
        st.id='rippleKF';
        st.textContent='@keyframes rippleAnim{to{transform:scale(1);opacity:0;}}';
        document.head.appendChild(st);
    }

    /* ── 4. EYE TOGGLE ── */
    const eyeBtn     = document.getElementById('eyeToggle');
    const pwField    = document.getElementById('loginPassword');
    const iconOpen   = document.getElementById('iconEyeOpen');
    const iconClosed = document.getElementById('iconEyeClosed');
    eyeBtn?.addEventListener('click', () => {
        const hidden = pwField.type === 'password';
        pwField.type             = hidden ? 'text'  : 'password';
        iconOpen.style.display   = hidden ? 'none'  : '';
        iconClosed.style.display = hidden ? ''      : 'none';
    });

    /* ── 5. LABEL HIGHLIGHT ── */
    document.querySelectorAll('.field-wrap input').forEach(inp => {
        const lbl = inp.closest('.field-group')?.querySelector('.field-label');
        inp.addEventListener('focus', ()=>{ if(lbl) lbl.style.color='#6c47ff'; });
        inp.addEventListener('blur',  ()=>{ if(lbl) lbl.style.color=''; });
    });

});
</script>
@endsection
