import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  TextInput,
  Modal,
  Alert,
  ActivityIndicator,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import StatusBadge from '../components/StatusBadge';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatDateIndonesia } from '../utils/formatters';

export default function LeaveScreen() {
  const { colors } = useTheme();
  const [leaves, setLeaves] = useState([]);
  const [quota, setQuota] = useState({ annual_total: 12, used: 2, remaining: 10 });
  const [loading, setLoading] = useState(true);
  const [modalVisible, setModalVisible] = useState(false);
  const [submitting, setSubmitting] = useState(false);

  // Form State
  const [leaveType, setLeaveType] = useState('TAHUNAN');
  const [startDate, setStartDate] = useState('2026-08-20');
  const [endDate, setEndDate] = useState('2026-08-21');
  const [reason, setReason] = useState('');

  const fetchLeaves = async () => {
    try {
      const res = await hrisApi.getLeaves();
      if (res.status === 'success') {
        setLeaves(res.data || []);
        if (res.quota) setQuota(res.quota);
      }
    } catch (e) {
      console.error('Error fetching leaves', e);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchLeaves();
  }, []);

  const handleSubmitLeave = async () => {
    if (!reason.trim()) {
      Alert.alert('Form Belum Lengkap', 'Harap isi alasan permohonan cuti / izin.');
      return;
    }

    setSubmitting(true);
    try {
      const res = await hrisApi.applyLeave({
        leave_type: leaveType,
        start_date: startDate,
        end_date: endDate,
        reason: reason.trim(),
      });

      if (res.status === 'success') {
        Alert.alert('Berhasil', res.message);
        setModalVisible(false);
        setReason('');
        fetchLeaves();
      } else {
        Alert.alert('Gagal', res.message);
      }
    } catch (e) {
      const msg = e.response?.data?.message || 'Gagal mengirim pengajuan cuti.';
      Alert.alert('Gagal', msg);
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Cuti &amp; Izin Online" subtitle="Manajemen Izin &amp; Cuti Pegawai" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Leave Quota Card */}
        <View style={[styles.quotaCard, { backgroundColor: colors.primary }]}>
          <View style={styles.quotaHeader}>
            <Text style={styles.quotaTitle}>KUOTA CUTI TAHUNAN (2026/2027)</Text>
            <Text style={styles.quotaBadge}>12 HARI / TAHUN</Text>
          </View>
          <View style={styles.quotaMetricRow}>
            <View style={styles.quotaMetric}>
              <Text style={styles.quotaMetricVal}>{quota.remaining}</Text>
              <Text style={styles.quotaMetricLabel}>Sisa Hari</Text>
            </View>
            <View style={styles.quotaDivider} />
            <View style={styles.quotaMetric}>
              <Text style={styles.quotaMetricVal}>{quota.used}</Text>
              <Text style={styles.quotaMetricLabel}>Terpakai</Text>
            </View>
            <View style={styles.quotaDivider} />
            <View style={styles.quotaMetric}>
              <Text style={styles.quotaMetricVal}>{quota.annual_total}</Text>
              <Text style={styles.quotaMetricLabel}>Total Hak Cuti</Text>
            </View>
          </View>
        </View>

        {/* Apply Button */}
        <TouchableOpacity
          style={[styles.applyBtn, { backgroundColor: colors.secondary }]}
          onPress={() => setModalVisible(true)}
          activeOpacity={0.8}
        >
          <Text style={styles.applyBtnText}>+ Ajukan Cuti / Izin Baru</Text>
        </TouchableOpacity>

        {/* History of Leaves */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Riwayat Permohonan Izin / Cuti</Text>

        {leaves.length === 0 ? (
          <View style={[styles.emptyBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
            <Text style={styles.emptyIcon}>📝</Text>
            <Text style={[styles.emptyText, { color: colors.text }]}>Belum ada permohonan cuti.</Text>
            <Text style={[styles.emptySub, { color: colors.textLight }]}>
              Klik tombol di atas untuk mengajukan cuti online.
            </Text>
          </View>
        ) : (
          leaves.map((item, idx) => (
            <View
              key={idx}
              style={[styles.leaveCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            >
              <View style={styles.leaveHeader}>
                <Text style={[styles.leaveTypeBadge, { color: colors.primary }]}>{item.leave_type}</Text>
                <StatusBadge status={item.status} />
              </View>

              <Text style={[styles.leaveDateRange, { color: colors.text }]}>
                📅 {formatDateIndonesia(item.start_date)} s/d {formatDateIndonesia(item.end_date)}
              </Text>
              <Text style={[styles.leaveDays, { color: colors.textLight }]}>
                Durasi: {item.total_days} Hari Kerja
              </Text>
              <Text style={[styles.leaveReason, { color: colors.text }]}>"{item.reason}"</Text>
            </View>
          ))
        )}

      </ScrollView>

      {/* Modal Form Pengajuan Cuti */}
      <Modal visible={modalVisible} animationType="slide" transparent onRequestClose={() => setModalVisible(false)}>
        <View style={styles.modalOverlay}>
          <View style={[styles.modalContent, { backgroundColor: colors.surface }]}>
            
            <View style={styles.modalHeader}>
              <Text style={[styles.modalTitle, { color: colors.text }]}>📝 Form Pengajuan Cuti / Izin</Text>
              <TouchableOpacity onPress={() => setModalVisible(false)} style={styles.closeBtn}>
                <Text style={styles.closeBtnText}>✕</Text>
              </TouchableOpacity>
            </View>

            <Text style={[styles.inputLabel, { color: colors.text }]}>Jenis Izin / Cuti</Text>
            <View style={styles.typeRow}>
              {['TAHUNAN', 'SAKIT', 'MELAHIRKAN', 'UMROH_HAJI', 'PENTING'].map((type) => (
                <TouchableOpacity
                  key={type}
                  style={[
                    styles.typeBtn,
                    {
                      backgroundColor: leaveType === type ? colors.primary : colors.surfaceSub,
                      borderColor: colors.border,
                    },
                  ]}
                  onPress={() => setLeaveType(type)}
                >
                  <Text style={[styles.typeBtnText, { color: leaveType === type ? '#fff' : colors.text }]}>
                    {type}
                  </Text>
                </TouchableOpacity>
              ))}
            </View>

            <Text style={[styles.inputLabel, { color: colors.text }]}>Tanggal Mulai (YYYY-MM-DD)</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              value={startDate}
              onChangeText={setStartDate}
              placeholder="2026-08-20"
            />

            <Text style={[styles.inputLabel, { color: colors.text }]}>Tanggal Selesai (YYYY-MM-DD)</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              value={endDate}
              onChangeText={setEndDate}
              placeholder="2026-08-21"
            />

            <Text style={[styles.inputLabel, { color: colors.text }]}>Alasan Permohonan</Text>
            <TextInput
              style={[
                styles.input,
                styles.textArea,
                { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text },
              ]}
              multiline
              numberOfLines={3}
              value={reason}
              onChangeText={setReason}
              placeholder="Tuliskan keperluan cuti/izin secara lengkap..."
              placeholderTextColor="#94a3b8"
            />

            <TouchableOpacity
              style={[styles.submitBtn, { backgroundColor: colors.primary }]}
              onPress={handleSubmitLeave}
              disabled={submitting}
              activeOpacity={0.8}
            >
              {submitting ? (
                <ActivityIndicator color="#fff" />
              ) : (
                <Text style={styles.submitBtnText}>Kirim Permohonan ke Pimpinan ➔</Text>
              )}
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
  quotaCard: {
    borderRadius: 22,
    padding: 18,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  quotaHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 12,
  },
  quotaTitle: {
    color: '#c6f634',
    fontSize: 10,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  quotaBadge: {
    color: '#ffffff',
    backgroundColor: 'rgba(255,255,255,0.2)',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
    fontSize: 9,
    fontWeight: '800',
  },
  quotaMetricRow: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    alignItems: 'center',
  },
  quotaMetric: {
    alignItems: 'center',
  },
  quotaMetricVal: {
    color: '#ffffff',
    fontSize: 26,
    fontWeight: '900',
  },
  quotaMetricLabel: {
    color: 'rgba(255,255,255,0.85)',
    fontSize: 10,
    fontWeight: '700',
    marginTop: 2,
  },
  quotaDivider: {
    width: 1,
    height: 35,
    backgroundColor: 'rgba(255,255,255,0.2)',
  },
  applyBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    marginBottom: 16,
  },
  applyBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
  },
  emptyBox: {
    padding: 24,
    borderRadius: 20,
    borderWidth: 1,
    alignItems: 'center',
  },
  emptyIcon: {
    fontSize: 32,
    marginBottom: 6,
  },
  emptyText: {
    fontSize: 13,
    fontWeight: '800',
  },
  emptySub: {
    fontSize: 11,
    marginTop: 2,
  },
  leaveCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 10,
  },
  leaveHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  leaveTypeBadge: {
    fontSize: 12,
    fontWeight: '900',
  },
  leaveDateRange: {
    fontSize: 12,
    fontWeight: '700',
  },
  leaveDays: {
    fontSize: 11,
    marginTop: 2,
  },
  leaveReason: {
    fontSize: 12,
    fontStyle: 'italic',
    marginTop: 6,
    lineHeight: 16,
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.6)',
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
  inputLabel: {
    fontSize: 11,
    fontWeight: '700',
    marginTop: 10,
    marginBottom: 4,
  },
  typeRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
    marginBottom: 6,
  },
  typeBtn: {
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 10,
    borderWidth: 1,
  },
  typeBtnText: {
    fontSize: 10,
    fontWeight: '800',
  },
  input: {
    paddingHorizontal: 12,
    paddingVertical: 10,
    borderRadius: 12,
    borderWidth: 1,
    fontSize: 12,
  },
  textArea: {
    height: 70,
    textAlignVertical: 'top',
  },
  submitBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    marginTop: 16,
  },
  submitBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
});
