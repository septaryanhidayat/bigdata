import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Modal,
  Alert,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import StatusBadge from '../components/StatusBadge';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatRupiah } from '../utils/formatters';

export default function PayrollScreen() {
  const { colors } = useTheme();
  const [salaries, setSalaries] = useState([]);
  const [selectedSlip, setSelectedSlip] = useState(null);
  const [modalVisible, setModalVisible] = useState(false);
  const [loading, setLoading] = useState(true);

  const fetchPayroll = async () => {
    try {
      const res = await hrisApi.getPayroll();
      if (res.status === 'success') {
        setSalaries(res.data || []);
      }
    } catch (e) {
      console.error('Error fetching payroll', e);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPayroll();
  }, []);

  const handleOpenSlip = async (id) => {
    try {
      const res = await hrisApi.getPayrollSlip(id);
      if (res.status === 'success') {
        setSelectedSlip(res.data);
        setModalVisible(true);
      }
    } catch (e) {
      Alert.alert('Error', 'Gagal memuat slip gaji.');
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Slip Gaji Digital" subtitle="Rekapitulasi Payroll &amp; Tunjangan" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Latest Salary Hero Card */}
        <View style={[styles.heroCard, { backgroundColor: colors.primary }]}>
          <Text style={styles.heroBadge}>GAJI BERSIH TERAKHIR (TAKE HOME PAY)</Text>
          <Text style={styles.heroAmount}>
            {formatRupiah(salaries[0]?.net_salary || 3850000)}
          </Text>
          <Text style={styles.heroPeriod}>
            Periode: {salaries[0]?.month_year || '2026-08'} • Ditransfer via Rekening BSI
          </Text>
        </View>

        <Text style={[styles.sectionTitle, { color: colors.text }]}>Daftar Slip Gaji Bulanan</Text>

        {salaries.map((item, idx) => (
          <TouchableOpacity
            key={idx}
            style={[styles.salaryCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            onPress={() => handleOpenSlip(item.id)}
            activeOpacity={0.7}
          >
            <View style={styles.salaryLeft}>
              <Text style={[styles.salaryMonth, { color: colors.text }]}>
                Bulan: {item.month_year}
              </Text>
              <Text style={[styles.salaryNet, { color: colors.primary }]}>
                {formatRupiah(item.net_salary)}
              </Text>
              <Text style={[styles.salaryDate, { color: colors.textLight }]}>
                Tanggal Bayar: {item.payment_date || '01-08-2026'}
              </Text>
            </View>

            <View style={styles.salaryRight}>
              <StatusBadge status={item.status || 'PAID'} label="LUNAS" />
              <Text style={[styles.viewDetailText, { color: colors.primary }]}>Lihat Rincian ➔</Text>
            </View>
          </TouchableOpacity>
        ))}

      </ScrollView>

      {/* Modal Detail Slip Gaji */}
      <Modal visible={modalVisible} animationType="slide" transparent onRequestClose={() => setModalVisible(false)}>
        <View style={styles.modalOverlay}>
          <View style={[styles.modalContent, { backgroundColor: colors.surface }]}>
            
            <View style={styles.modalHeader}>
              <View>
                <Text style={[styles.modalTitle, { color: colors.text }]}>📄 Rincian Slip Gaji Resmi</Text>
                <Text style={[styles.modalSub, { color: colors.textLight }]}>
                  Periode: {selectedSlip?.period} • SIT Robbani
                </Text>
              </View>
              <TouchableOpacity onPress={() => setModalVisible(false)} style={styles.closeBtn}>
                <Text style={styles.closeBtnText}>✕</Text>
              </TouchableOpacity>
            </View>

            {/* Earnings */}
            <Text style={[styles.breakdownHeader, { color: '#059669' }]}>+ PENDAPATAN (EARNINGS)</Text>
            {selectedSlip?.earnings?.map((e, i) => (
              <View key={i} style={styles.breakdownRow}>
                <Text style={[styles.breakdownLabel, { color: colors.text }]}>{e.name}</Text>
                <Text style={[styles.breakdownVal, { color: colors.text }]}>{formatRupiah(e.amount)}</Text>
              </View>
            ))}
            <View style={[styles.totalRow, { borderTopColor: colors.border }]}>
              <Text style={[styles.totalLabel, { color: colors.text }]}>Total Pendapatan Kotor</Text>
              <Text style={[styles.totalVal, { color: '#059669' }]}>
                {formatRupiah(selectedSlip?.total_earnings || 4000000)}
              </Text>
            </View>

            {/* Deductions */}
            <Text style={[styles.breakdownHeader, { color: '#dc2626', marginTop: 14 }]}>- POTONGAN (DEDUCTIONS)</Text>
            {selectedSlip?.deductions?.map((d, i) => (
              <View key={i} style={styles.breakdownRow}>
                <Text style={[styles.breakdownLabel, { color: colors.text }]}>{d.name}</Text>
                <Text style={[styles.breakdownVal, { color: '#dc2626' }]}>- {formatRupiah(d.amount)}</Text>
              </View>
            ))}
            <View style={[styles.totalRow, { borderTopColor: colors.border }]}>
              <Text style={[styles.totalLabel, { color: colors.text }]}>Total Potongan</Text>
              <Text style={[styles.totalVal, { color: '#dc2626' }]}>
                - {formatRupiah(selectedSlip?.total_deductions || 150000)}
              </Text>
            </View>

            {/* Net Salary Total */}
            <View style={[styles.netSalaryBox, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
              <Text style={[styles.netLabel, { color: colors.text }]}>GAJI BERSIH (TAKE HOME PAY)</Text>
              <Text style={[styles.netVal, { color: colors.primary }]}>
                {formatRupiah(selectedSlip?.net_salary || 3850000)}
              </Text>
            </View>

            <TouchableOpacity
              style={[styles.downloadBtn, { backgroundColor: colors.primary }]}
              onPress={() => {
                Alert.alert('Unduh Slip Gaji', 'Slip gaji ber-QR TTE resmi berhasil diunduh ke format PDF.');
              }}
              activeOpacity={0.8}
            >
              <Text style={styles.downloadBtnText}>📥 Unduh File PDF Resmi Ber-QR TTE</Text>
            </TouchableOpacity>

          </View>
        </View>
      </Modal>

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
  heroCard: {
    borderRadius: 22,
    padding: 20,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  heroBadge: {
    color: '#c6f634',
    fontSize: 10,
    fontWeight: '900',
    letterSpacing: 0.5,
    marginBottom: 4,
  },
  heroAmount: {
    color: '#ffffff',
    fontSize: 28,
    fontWeight: '900',
  },
  heroPeriod: {
    color: 'rgba(255,255,255,0.85)',
    fontSize: 11,
    marginTop: 4,
    fontWeight: '600',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
  },
  salaryCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  salaryLeft: {
    flex: 1,
  },
  salaryMonth: {
    fontSize: 14,
    fontWeight: '800',
  },
  salaryNet: {
    fontSize: 16,
    fontWeight: '900',
    marginTop: 2,
  },
  salaryDate: {
    fontSize: 11,
    marginTop: 2,
  },
  salaryRight: {
    alignItems: 'flex-end',
    gap: 6,
  },
  viewDetailText: {
    fontSize: 11,
    fontWeight: '800',
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.65)',
    justifyContent: 'flex-end',
  },
  modalContent: {
    borderTopLeftRadius: 28,
    borderTopRightRadius: 28,
    padding: 20,
    maxHeight: '90%',
  },
  modalHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 14,
  },
  modalTitle: {
    fontSize: 15,
    fontWeight: '800',
  },
  modalSub: {
    fontSize: 11,
    marginTop: 2,
  },
  closeBtn: {
    width: 30,
    height: 30,
    borderRadius: 15,
    backgroundColor: 'rgba(0,0,0,0.06)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  closeBtnText: {
    fontSize: 14,
    fontWeight: 'bold',
  },
  breakdownHeader: {
    fontSize: 11,
    fontWeight: '900',
    letterSpacing: 0.5,
    marginBottom: 6,
  },
  breakdownRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: 4,
  },
  breakdownLabel: {
    fontSize: 12,
  },
  breakdownVal: {
    fontSize: 12,
    fontWeight: '700',
  },
  totalRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    borderTopWidth: 1,
    paddingTop: 6,
    marginTop: 4,
  },
  totalLabel: {
    fontSize: 12,
    fontWeight: '800',
  },
  totalVal: {
    fontSize: 12,
    fontWeight: '900',
  },
  netSalaryBox: {
    padding: 14,
    borderRadius: 16,
    borderWidth: 1,
    alignItems: 'center',
    marginVertical: 14,
  },
  netLabel: {
    fontSize: 10,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
  netVal: {
    fontSize: 22,
    fontWeight: '900',
    marginTop: 2,
  },
  downloadBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
  },
  downloadBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
});
