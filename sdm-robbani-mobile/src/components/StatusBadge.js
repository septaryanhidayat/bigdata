import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

export default function StatusBadge({ status, label }) {
  const getBadgeStyle = () => {
    switch (status?.toUpperCase()) {
      case 'PRESENT':
      case 'APPROVED':
      case 'PAID':
      case 'A':
        return { bg: '#dcfce7', text: '#15803d', label: label || 'Hadir / Disetujui' };
      case 'LATE':
      case 'PENDING':
      case 'B':
        return { bg: '#fef3c7', text: '#b45309', label: label || 'Terlambat / Menunggu' };
      case 'SICK':
      case 'PERMIT':
      case 'LEAVE':
      case 'C':
        return { bg: '#e0f2fe', text: '#0369a1', label: label || 'Izin / Cuti / Sakit' };
      case 'REJECTED':
      case 'CANCELLED':
      case 'D':
        return { bg: '#fee2e2', text: '#b91c1c', label: label || 'Ditolak / Batal' };
      default:
        return { bg: '#f1f5f9', text: '#475569', label: label || status || 'Status' };
    }
  };

  const badge = getBadgeStyle();

  return (
    <View style={[styles.badge, { backgroundColor: badge.bg }]}>
      <Text style={[styles.badgeText, { color: badge.text }]}>{badge.label}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  badge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 8,
    alignSelf: 'flex-start',
  },
  badgeText: {
    fontSize: 10,
    fontWeight: '800',
    textTransform: 'uppercase',
  },
});
