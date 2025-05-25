import React, { useState, useEffect, useContext } from "react";
import { View, Text, StyleSheet, FlatList } from "react-native";
import { AuthContext } from "../context/AuthContext";

// Statik örnek veriler (API'den gelecek şekilde)
const sampleNotifications = [
  {
    id: 1,
    title: "Yeni Deneme Yayınlandı",
    description: "tyt genel 04 sınavı sisteme eklendi.",
    time: "21:35",
    is_read: false,
  },
  {
    id: 2,
    title: "Yeni Deneme Yayınlandı",
    description: "tyt genel 03 sınavı sisteme eklendi.",
    time: "12:19",
    is_read: true,
  },
  {
    id: 3,
    title: "Yeni Deneme Yayınlandı",
    description: "tyt genel 02 sınavı sisteme eklendi.",
    time: "12:16",
    is_read: false,
  },
];

export default function NotificationScreen() {
  const { token } = useContext(AuthContext);
  const [notifications, setNotifications] = useState([]);

  useEffect(() => {
    // Geçici olarak statik veri yükleniyor
    setNotifications(sampleNotifications);
  }, []);

  const renderItem = ({ item }) => (
    <View style={[styles.card, item.is_read && styles.read]}>
      <Text style={styles.title}>{item.title}</Text>
      <Text style={styles.description}>{item.description}</Text>
      <View style={styles.footer}>
        {item.is_read && <Text style={styles.readLabel}>Okundu</Text>}
        <Text style={styles.time}>{item.time}</Text>
      </View>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.header}>📢 Bildirimler</Text>
      <FlatList
        data={notifications}
        keyExtractor={(item) => item.id.toString()}
        renderItem={renderItem}
        contentContainerStyle={{ paddingBottom: 20 }}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 16, backgroundColor: "#fff" },
  header: { fontSize: 22, fontWeight: "bold", marginBottom: 16 },
  card: {
    backgroundColor: "#f8f9fa",
    padding: 15,
    borderRadius: 10,
    marginBottom: 12,
  },
  read: {
    backgroundColor: "#e0e0e0",
  },
  title: { fontWeight: "bold", fontSize: 16, marginBottom: 4 },
  description: { fontSize: 14, color: "#333" },
  footer: {
    flexDirection: "row",
    justifyContent: "space-between",
    marginTop: 8,
  },
  time: { fontSize: 12, color: "gray" },
  readLabel: {
    backgroundColor: "#4CAF50",
    color: "#fff",
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 5,
    fontSize: 12,
  },
});