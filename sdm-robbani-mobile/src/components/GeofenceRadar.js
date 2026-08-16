import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { useTheme } from '../context/ThemeContext';

export default function GeofenceRadar({ distanceMeters, maxRadiusMeters = 150, isMockDetected = false }) {
  const { colors } = useTheme();
  const isInside = distanceMeters !== null && distanceMeters <= maxRadiusMeters;

  return (
    <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
      <View style={styles.headerRow}>
        <Text style={[styles.title, { color: colors.text }]}>📍 Geofencing Radar Kampus</Text>
        {isMockDetected ? (
          <View style={[styles.badge, { backgroundColor: '#fee2e2' }]}>
            <Text style={[styles.badgeText, { color: '#dc2626' }]}>⚠️ FAKE GPS DETECTED</Text>
          </View>
        ) : (
          <View style={[styles.badge, { backgroundColor: isInside ? '#dcfce7' : '#fef3c7' }]}>
            <Text style={[styles.badgeText, { color: isInside ? '#16a34a' : '#d97706' }]}>
              {isInside ? '✓ DALAM RADIUS' : 'LUAR RADIUS'}
            </Text>
          </View>
        )}
      </View>

      <View style={styles.radarContainer}>
        <View style={[styles.radarCircleOuter, { borderColor: isInside ? '#10b981' : '#f59e0b' }]}>
          <View style={[styles.radarCircleMiddle, { borderColor: isInside ? '#34d399' : '#fbbf24' }]}>
            <View style={[styles.radarCenterDot, { backgroundColor: isInside ? '#059669' : '#d97706' }]}>
              <Text style={styles.dotIcon}>🏫</Text>
            </View>
          </View>
        </View>

        <View style={styles.metricsContainer}>
          <View style={styles.metricItem}>
            <Text style={[styles.metricLabel, { color: colors.textLight }]}>Jarak Anda</Text>
            <Text style={[styles.metricValue, { color: isInside ? '#16a34a' : '#dc2626' }]}>
              {distanceMeters !== null ? `${distanceMeters} m` : 'Mendeteksi...'}
            </Text>
          </View>
          <View style={styles.metricDivider} />
          <View style={styles.metricItem}>
            <Text style={[styles.metricLabel, { color: colors.textLight }]}>Maksimal Radius</Text>
            <Text style={[styles.metricValue, { color: colors.text }]}>{maxRadiusMeters} m</Text>
          </View>
        </View>
      </View>

      <Text style={[styles.footerNote, { color: colors.textLight }]}>
        {isMockDetected
          ? '❌ Terdeteksi lokasi tiruan (Mock GPS). Presensi dinonaktifkan.'
          : isInside
          ? '✓ Anda berada dalam area jangkauan unit sekolah. Siap presensi wajah.'
          : `⚠️ Geser posisi Anda mendekati sekolah (kurang dari ${maxRadiusMeters} meter).`}
      </Text>
    </View>
  );
}

const styles = StyleSheet.create({
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginVertical: 8,
    shadowColor: '#000',
    shadowOpacity: 0.04,
    shadowRadius: 10,
    elevation: 2,
  },
  headerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 12,
  },
  title: {
    fontSize: 13,
    fontWeight: '800',
  },
  badge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 8,
  },
  badgeText: {
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  radarContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 8,
  },
  radarCircleOuter: {
    width: 72,
    height: 72,
    borderRadius: 36,
    borderWidth: 1.5,
    alignItems: 'center',
    justifyContent: 'center',
    borderStyle: 'dashed',
  },
  radarCircleMiddle: {
    width: 48,
    height: 48,
    borderRadius: 24,
    borderWidth: 1.5,
    alignItems: 'center',
    justifyContent: 'center',
  },
  radarCenterDot: {
    width: 28,
    height: 28,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
  },
  dotIcon: {
    fontSize: 14,
  },
  metricsContainer: {
    flex: 1,
    flexDirection: 'row',
    marginLeft: 16,
    alignItems: 'center',
    justifyContent: 'space-around',
    backgroundColor: 'rgba(0,0,0,0.02)',
    padding: 10,
    borderRadius: 14,
  },
  metricItem: {
    alignItems: 'center',
  },
  metricLabel: {
    fontSize: 10,
    fontWeight: '600',
    marginBottom: 2,
  },
  metricValue: {
    fontSize: 15,
    fontWeight: '900',
  },
  metricDivider: {
    width: 1,
    height: 24,
    backgroundColor: 'rgba(0,0,0,0.1)',
  },
  footerNote: {
    fontSize: 11,
    marginTop: 8,
    fontWeight: '500',
    lineHeight: 15,
  },
});
