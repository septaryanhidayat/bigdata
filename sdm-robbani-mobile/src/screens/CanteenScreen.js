import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  Alert,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatRupiah } from '../utils/formatters';

export default function CanteenScreen() {
  const { colors } = useTheme();
  const [walletBalance, setWalletBalance] = useState(350000);
  const [products, setProducts] = useState([]);

  useEffect(() => {
    const fetchCanteen = async () => {
      try {
        const res = await hrisApi.getCanteenProducts();
        if (res.status === 'success') {
          setProducts(res.products || []);
          if (res.wallet_balance) setWalletBalance(res.wallet_balance);
        }
      } catch (e) {
        console.error('Error fetching canteen', e);
      }
    };
    fetchCanteen();
  }, []);

  const handleBuy = (item) => {
    if (walletBalance < item.price) {
      Alert.alert('Saldo Tidak Cukup', 'Saldo dompet pegawai Anda tidak mencukupi untuk transaksi ini.');
      return;
    }

    Alert.alert(
      'Konfirmasi Pembayaran',
      `Beli ${item.name} seharga ${formatRupiah(item.price)} menggunakan saldo dompet pegawai?`,
      [
        { text: 'Batal', style: 'cancel' },
        {
          text: 'Bayar Sekarang',
          onPress: async () => {
            try {
              const res = await hrisApi.payCanteen(item.id, item.price);
              if (res.status === 'success') {
                setWalletBalance((prev) => prev - item.price);
                Alert.alert('Pembayaran Berhasil', `No Resi: ${res.receipt_number}\nSisa Saldo: ${formatRupiah(res.remaining_balance)}`);
              }
            } catch (e) {
              Alert.alert('Gagal', 'Terjadi kesalahan transaksi.');
            }
          },
        },
      ]
    );
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Kantin &amp; Koperasi" subtitle="Belanja Non-Tunai Dompet SDM" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Wallet Balance Hero Card */}
        <View style={[styles.walletCard, { backgroundColor: colors.primary }]}>
          <View style={styles.walletHeader}>
            <Text style={styles.walletBadge}>DOMPET DIGITAL PEGAWAI</Text>
            <Text style={styles.walletQrIcon}>📲 QR PAY</Text>
          </View>
          <Text style={styles.walletBalance}>{formatRupiah(walletBalance)}</Text>
          <Text style={styles.walletNote}>Bisa digunakan di seluruh Kantin &amp; Koperasi Kampus SIT Robbani</Text>
        </View>

        {/* Product Catalog */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Katalog Menu Kantin &amp; Koperasi</Text>

        <View style={styles.productGrid}>
          {products.map((item) => (
            <View
              key={item.id}
              style={[styles.productCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            >
              <Image source={{ uri: item.image }} style={styles.productImg} />
              <View style={styles.productInfo}>
                <Text style={[styles.productCat, { color: colors.primary }]}>{item.category}</Text>
                <Text style={[styles.productName, { color: colors.text }]} numberOfLines={2}>
                  {item.name}
                </Text>
                <Text style={[styles.productPrice, { color: colors.text }]}>{formatRupiah(item.price)}</Text>

                <TouchableOpacity
                  style={[styles.buyBtn, { backgroundColor: colors.primary }]}
                  onPress={() => handleBuy(item)}
                  activeOpacity={0.8}
                >
                  <Text style={styles.buyBtnText}>Beli Non-Tunai</Text>
                </TouchableOpacity>
              </View>
            </View>
          ))}
        </View>

      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  walletCard: {
    borderRadius: 22,
    padding: 20,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  walletHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 4,
  },
  walletBadge: {
    color: '#c6f634',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  walletQrIcon: {
    color: '#ffffff',
    backgroundColor: 'rgba(255,255,255,0.2)',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
    fontSize: 9,
    fontWeight: '800',
  },
  walletBalance: {
    color: '#ffffff',
    fontSize: 28,
    fontWeight: '900',
    marginVertical: 4,
  },
  walletNote: {
    color: 'rgba(255,255,255,0.85)',
    fontSize: 11,
    fontWeight: '500',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
  },
  productGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
  },
  productCard: {
    width: '48%',
    borderRadius: 18,
    borderWidth: 1,
    overflow: 'hidden',
  },
  productImg: {
    width: '100%',
    height: 110,
  },
  productInfo: {
    padding: 10,
  },
  productCat: {
    fontSize: 9,
    fontWeight: '900',
    textTransform: 'uppercase',
  },
  productName: {
    fontSize: 12,
    fontWeight: '800',
    marginTop: 2,
    height: 32,
  },
  productPrice: {
    fontSize: 13,
    fontWeight: '900',
    marginTop: 4,
  },
  buyBtn: {
    paddingVertical: 8,
    borderRadius: 10,
    alignItems: 'center',
    marginTop: 8,
  },
  buyBtnText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '800',
  },
});
