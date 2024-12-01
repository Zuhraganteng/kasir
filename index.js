// Data dummy untuk daftar makanan dan minuman
const products = {
    makanan: [
        { id: 1, name: "Nasi Goreng", price: 15000 },
        { id: 2, name: "Mie Ayam", price: 12000 },
        { id: 3, name: "Sate Ayam", price: 20000 },
        { id: 4, name: "Gado-Gado", price: 10000 },
        { id: 5, name: "Soto Ayam", price: 15000 },
        { id: 6, name: "Bakso", price: 13000 },
        { id: 7, name: "Ayam Goreng", price: 18000 },
        { id: 8, name: "Rendang", price: 25000 },
        { id: 9, name: "Nasi Padang", price: 20000 },
        { id: 10, name: "Pempek", price: 15000 },
    ],
    minuman: [
        { id: 11, name: "Es Teh", price: 5000 },
        { id: 12, name: "Es Jeruk", price: 6000 },
        { id: 13, name: "Kopi", price: 8000 },
        { id: 14, name: "Jus Alpukat", price: 10000 },
        { id: 15, name: "Jus Mangga", price: 9000 },
        { id: 16, name: "Es Kelapa", price: 7000 },
        { id: 17, name: "Teh Panas", price: 4000 },
        { id: 18, name: "Susu Coklat", price: 8000 },
        { id: 19, name: "Air Mineral", price: 3000 },
        { id: 20, name: "Soda Gembira", price: 10000 },
    ]
};

// Variabel untuk menyimpan keranjang dan riwayat transaksi
let cart = [];
let transactionHistory = [];

// Function untuk menampilkan daftar barang
function showProducts(category) {
    const productList = document.getElementById('productList');
    productList.innerHTML = '';
    products[category].forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');
        productCard.innerHTML = `
            <h3>${product.name}</h3>
            <p>Harga: ${product.price}</p>
            <button onclick="addToCart(${product.id}, '${category}')">Tambah ke Keranjang</button>
        `;
        productList.appendChild(productCard);
    });
}

// Function untuk pencarian barang
function search() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const productList = document.getElementById('productList');
    productList.innerHTML = '';

    for (let category in products) {
        const filteredProducts = products[category].filter(product =>
            product.name.toLowerCase().includes(searchInput)
        );
        filteredProducts.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            productCard.innerHTML = `
                <h3>${product.name}</h3>
                <p>Harga: ${product.price}</p>
                <button onclick="addToCart(${product.id}, '${category}')">Tambah ke Keranjang</button>
            `;
            productList.appendChild(productCard);
        });
    }
}

// Function untuk menambah barang ke keranjang belanja
function addToCart(productId, category) {
    const selectedProduct = products[category].find(product => product.id === productId);
    if (selectedProduct) {
        cart.push(selectedProduct);
        alert(`Produk ${selectedProduct.name} ditambahkan ke keranjang!`);
    }
}

// Function untuk menampilkan keranjang belanja
function showCart() {
    const productList = document.getElementById('productList');
    productList.innerHTML = '';
    cart.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');
        productCard.innerHTML = `
            <h3>${product.name}</h3>
            <p>Harga: ${product.price}</p>
        `;
        productList.appendChild(productCard);
    });
}

// Function untuk checkout
function checkout() {
    const total = cart.reduce((acc, product) => acc + product.price, 0);
    alert(`Total belanja Anda: ${total}`);
    transactionHistory.push([...cart]);
    cart = [];
    showTransactionPopup(total);
}

// Function untuk menampilkan pop-up dengan rincian transaksi
function showTransactionPopup(total) {
    const popupOverlay = document.getElementById('popupOverlay');
    const transactionDetails = document.getElementById('transactionDetails');
    transactionDetails.innerHTML = '';
    cart.forEach(product => {
        const productDetail = document.createElement('p');
        productDetail.innerText = `${product.name} - ${product.price}`;
        transactionDetails.appendChild(productDetail);
    });
    const totalDetail = document.createElement('p');
    totalDetail.innerText = `Total: ${total}`;
    transactionDetails.appendChild(totalDetail);
    popupOverlay.style.display = 'flex';
}

// Function untuk menutup pop-up
function closePopup() {
    const popupOverlay = document.getElementById('popupOverlay');
    popupOverlay.style.display = 'none';
}

// Function untuk menampilkan riwayat pembelian
function showHistory() {
    const productList = document.getElementById('productList');
    productList.innerHTML = '';
    transactionHistory.forEach((transaction, index) => {
        const transactionCard = document.createElement('div');
        transactionCard.classList.add('transaction-card');
        transactionCard.innerHTML = `
            <h3>Transaksi ${index + 1}</h3>
            <ul>
                ${transaction.map(item => `<li>${item.name} - ${item.price}</li>`).join('')}
            </ul>
        `;
        productList.appendChild(transactionCard);
    });
}

// Function untuk mendownload laporan penjualan
function downloadReport() {
    let reportContent = "Transaksi,Produk,Harga\n";
    transactionHistory.forEach((transaction, index) => {
        transaction.forEach(item => {
            reportContent += `${index + 1},${item.name},${item.price}\n`;
        });
    });
    const blob = new Blob([reportContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'laporan_penjualan.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
