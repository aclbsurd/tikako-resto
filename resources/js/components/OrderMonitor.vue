<template>
    <div v-if="newOrderCount > 0" class="alert alert-danger pulse-effect shadow" role="alert">
        <h5 class="mb-0 fw-bold">
            🔔 {{ newOrderCount }} PESANAN BARU MASUK!
        </h5>
        <small>Klik untuk memuat ulang halaman.</small>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            lastOrderId: 0, // ID pesanan terakhir yang kita lihat (default 0)
            newOrderCount: 0, // Jumlah pesanan baru yang masuk
            pollingInterval: null, // Variabel untuk menyimpan interval polling
        };
    },
    methods: {
        // Fungsi utama untuk memanggil API
        fetchNewOrders() {
            axios.get('/api/admin/orders/latest')
                .then(response => {
                    const latestOrder = response.data.latest_order;
                    const totalNew = response.data.new_count;

                    // Jika ini adalah pengecekan pertama, simpan ID pesanan terakhir
                    if (this.lastOrderId === 0 && latestOrder) {
                        this.lastOrderId = latestOrder.id;
                        return;
                    }

                    // Jika ID pesanan terbaru di server lebih besar dari ID yang kita miliki,
                    // artinya ada pesanan baru.
                    if (latestOrder && latestOrder.id > this.lastOrderId) {
                        
                        // 1. Perbarui jumlah pesanan baru (Notifikasi muncul)
                        this.newOrderCount = totalNew; 

                        // 2. Simpan ID baru sebagai yang terakhir dilihat
                        this.lastOrderId = latestOrder.id; 
                        
                        // 3. !! TAMBAHKAN LOGIKA AUTO-REFRESH DENGAN JEDA 3 DETIK !!
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000); // Reload setelah 3 detik

                    }
                })
                .catch(error => {
                    console.error('Error fetching new orders:', error);
                });
        },
        
        // Fungsi refreshPage yang lama sekarang tidak terlalu dibutuhkan, tapi biarkan saja
        refreshPage() {
            if (this.newOrderCount > 0) {
                window.location.reload();
            }
        }
    },
    mounted() {
        // Panggil fungsi sekali saat komponen dimuat
        this.fetchNewOrders(); 
        
        // Panggil fungsi berulang setiap 10 detik (10000ms)
        this.pollingInterval = setInterval(this.fetchNewOrders, 10000); 
        
        // Tambahkan listener click ke elemen notifikasi
        this.$el.addEventListener('click', this.refreshPage);
    },
    beforeDestroy() {
        // Hapus interval polling saat komponen dihancurkan
        clearInterval(this.pollingInterval); 
        this.$el.removeEventListener('click', this.refreshPage);
    }
}
</script>

<style scoped>
/* Style hanya berlaku untuk komponen ini */
.pulse-effect {
    cursor: pointer;
    border-radius: 8px;
    /* Animasi sederhana untuk menarik perhatian */
    animation: pulse 1s infinite alternate; 
    position: fixed;
    top: 60px; /* Di bawah navbar */
    right: 20px;
    z-index: 1000;
}
@keyframes pulse {
    from {
        transform: scale(1);
    }
    to {
        transform: scale(1.03);
    }
}
</style>