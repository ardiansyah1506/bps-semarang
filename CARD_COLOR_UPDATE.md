# Update Warna Card - Menjadi Putih

## 🎨 Perubahan yang Telah Dilakukan

### **Masalah**: Card masih berwarna hitam
### **Solusi**: Mengubah semua card menjadi putih dengan text hitam

## ✅ Perubahan CSS yang Ditambahkan

### 1. **Card Background Utama**
```css
.card {
    background: #ffffff;
    color: #333333;
}
```

### 2. **Card Body & Footer**
```css
.card-body {
    background: #ffffff;
    padding: 25px;
}

.card-footer {
    background: #ffffff;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}
```

### 3. **Override Semua Kondisi**
```css
/* Ensure all cards are white */
.card,
.card-body,
.card-footer {
    background-color: #ffffff !important;
    color: #333333 !important;
}
```

### 4. **Override Bootstrap Classes**
```css
.card.bg-dark,
.card.bg-secondary,
.card.bg-light {
    background-color: #ffffff !important;
    color: #333333 !important;
}
```

### 5. **Text Colors**
```css
.card h1, .card h2, .card h3, .card h4, .card h5, .card h6 {
    color: #333333 !important;
}

.card p, .card span, .card div {
    color: #333333 !important;
}
```

### 6. **Card Header Tetap BPS Colors**
```css
.card-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%) !important;
    color: white !important;
}
```

## 📱 Responsif di Semua Device

### Mobile (< 768px)
```css
.card {
    background-color: #ffffff !important;
    color: #333333 !important;
}
```

### Mobile Kecil (< 480px)
```css
.card {
    background-color: #ffffff !important;
    color: #333333 !important;
}
```

### Landscape & Portrait
```css
.card {
    background-color: #ffffff !important;
    color: #333333 !important;
}
```

## 🌙 Dark Mode Override
```css
@media (prefers-color-scheme: dark) {
    .card {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
    
    .card-body {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
    
    .card-footer {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
}
```

## 🖨️ Print Mode
```css
@media print {
    .card {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
}
```

## 🎯 High Contrast Mode
```css
@media (prefers-contrast: high) {
    .card {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
    
    .card-body {
        background-color: #ffffff !important;
        color: #333333 !important;
    }
}
```

## ✅ Hasil Akhir

- ✅ **Semua card sekarang berwarna putih**
- ✅ **Text dalam card berwarna hitam (#333333)**
- ✅ **Card header tetap menggunakan warna BPS (biru gradient)**
- ✅ **Responsif di semua device (mobile, tablet, desktop)**
- ✅ **Override semua mode (dark mode, high contrast, print)**
- ✅ **Tidak ada perubahan pada fungsi website**

## 🎨 Warna yang Digunakan

- **Card Background**: `#ffffff` (Putih)
- **Card Text**: `#333333` (Hitam Soft)
- **Card Header**: Gradient biru BPS
- **Card Border**: Transparan dengan shadow

Sekarang semua card di website BPS Kota Semarang akan tampil dengan background putih dan text hitam yang mudah dibaca! 🎉 