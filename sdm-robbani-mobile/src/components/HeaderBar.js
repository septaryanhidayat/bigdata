import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity, Image, Platform, StatusBar } from 'react-native';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';

export default function HeaderBar({ title, subtitle, showUnitBadge = true, showBack = false, onBack }) {
  const { user, employee, unit } = useAuth();
  const { colors, isDarkMode, toggleDarkMode } = useTheme();

  return (
    <View style={[styles.container, { backgroundColor: colors.surface, borderBottomColor: colors.border }]}>
      <View style={styles.leftRow}>
        {showBack ? (
          <TouchableOpacity style={[styles.backBtn, { backgroundColor: colors.surfaceSub }]} onPress={onBack}>
            <Text style={[styles.backBtnText, { color: colors.text }]}>‹</Text>
          </TouchableOpacity>
        ) : (
          <Image
            source={{ uri: user?.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}
            style={[styles.avatar, { borderColor: colors.primary }]}
          />
        )}
        <View style={styles.textContainer}>
          <Text style={[styles.title, { color: colors.text }]} numberOfLines={1}>
            {title || user?.name || 'Pegawai SIT Robbani'}
          </Text>
          <Text style={[styles.subtitle, { color: colors.textSub }]} numberOfLines={1}>
            {subtitle || employee?.position || unit?.name || 'Pendidik / Tenaga Kependidikan'}
          </Text>
        </View>
      </View>

      <View style={styles.rightRow}>
        {showUnitBadge && unit && (
          <View style={[styles.unitBadge, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
            <Text style={[styles.unitBadgeText, { color: colors.primary }]}>{unit.code}</Text>
          </View>
        )}
        <TouchableOpacity
          onPress={toggleDarkMode}
          style={[styles.iconButton, { backgroundColor: colors.surfaceSub }]}
          activeOpacity={0.7}
        >
          <Text style={styles.iconText}>{isDarkMode ? '☀️' : '🌙'}</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    paddingHorizontal: 16,
    paddingTop: Platform.OS === 'android' ? (StatusBar.currentHeight || 28) + 10 : 38,
    paddingBottom: 14,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    borderBottomWidth: 1,
  },
  leftRow: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  backBtn: {
    width: 36,
    height: 36,
    borderRadius: 18,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 10,
  },
  backBtnText: {
    fontSize: 26,
    fontWeight: '900',
    marginTop: -4,
  },
  avatar: {
    width: 40,
    height: 40,
    borderRadius: 20,
    borderWidth: 2,
    marginRight: 10,
  },
  textContainer: {
    flex: 1,
  },
  title: {
    fontSize: 14,
    fontWeight: '800',
    letterSpacing: -0.2,
  },
  subtitle: {
    fontSize: 11,
    fontWeight: '600',
    marginTop: 2,
  },
  rightRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  unitBadge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 8,
    borderWidth: 1,
  },
  unitBadgeText: {
    fontSize: 10,
    fontWeight: '900',
    textTransform: 'uppercase',
  },
  iconButton: {
    width: 34,
    height: 34,
    borderRadius: 17,
    alignItems: 'center',
    justifyContent: 'center',
  },
  iconText: {
    fontSize: 14,
  },
});
