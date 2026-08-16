import React from 'react';
import { TouchableOpacity, View, Text, StyleSheet } from 'react-native';
import { useTheme } from '../context/ThemeContext';

export default function QuickActionCard({ title, icon, subtitle, onPress, badge }) {
  const { colors } = useTheme();

  return (
    <TouchableOpacity
      style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}
      onPress={onPress}
      activeOpacity={0.7}
    >
      {badge && (
        <View style={[styles.badge, { backgroundColor: colors.secondary }]}>
          <Text style={styles.badgeText}>{badge}</Text>
        </View>
      )}
      <View style={[styles.iconContainer, { backgroundColor: colors.surfaceSub }]}>
        <Text style={styles.icon}>{icon}</Text>
      </View>
      <Text style={[styles.title, { color: colors.text }]} numberOfLines={1}>
        {title}
      </Text>
      {subtitle && (
        <Text style={[styles.subtitle, { color: colors.textLight }]} numberOfLines={1}>
          {subtitle}
        </Text>
      )}
    </TouchableOpacity>
  );
}

const styles = StyleSheet.create({
  card: {
    flex: 1,
    padding: 14,
    borderRadius: 20,
    borderWidth: 1,
    alignItems: 'center',
    justifyContent: 'center',
    margin: 4,
    position: 'relative',
    shadowColor: '#000',
    shadowOpacity: 0.03,
    shadowRadius: 6,
    elevation: 1,
    minHeight: 100,
  },
  badge: {
    position: 'absolute',
    top: 6,
    right: 6,
    paddingHorizontal: 5,
    paddingVertical: 2,
    borderRadius: 6,
  },
  badgeText: {
    color: '#ffffff',
    fontSize: 8,
    fontWeight: '900',
    textTransform: 'uppercase',
  },
  iconContainer: {
    width: 44,
    height: 44,
    borderRadius: 22,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 8,
  },
  icon: {
    fontSize: 22,
  },
  title: {
    fontSize: 12,
    fontWeight: '800',
    textAlign: 'center',
  },
  subtitle: {
    fontSize: 10,
    marginTop: 2,
    fontWeight: '500',
    textAlign: 'center',
  },
});
