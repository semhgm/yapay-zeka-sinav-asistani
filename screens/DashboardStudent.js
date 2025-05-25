import React from "react";
import { View, Text, TouchableOpacity, StyleSheet, ScrollView } from "react-native";
import { useNavigation } from "@react-navigation/native";

export default function DashboardStudent() {
  const navigation = useNavigation();

  const modules = [
    { title: "📅 Takvim", screen: "Calendar" },
    { title: "🧠 Çalışma Programı", screen: "StudyPlan" },
    { title: "📈 Sınav Analizleri", screen: "ExamAnalysis" },
    { title: "📝 Notlarım", screen: "Notes" },
    { title: "🔔 Bildirimler", screen: "Notifications" }, // Yeni eklendi
  ];

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.heading}>Hoş geldin 👋</Text>
      {modules.map((mod, idx) => (
        <TouchableOpacity
          key={idx}
          style={styles.card}
          onPress={() => navigation.navigate(mod.screen)}
        >
          <Text style={styles.cardText}>{mod.title}</Text>
        </TouchableOpacity>
      ))}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    padding: 20,
    backgroundColor: "#f8f8f8",
    flexGrow: 1,
  },
  heading: {
    fontSize: 24,
    fontWeight: "bold",
    marginBottom: 25,
    color: "#333",
  },
  card: {
    backgroundColor: "#fff",
    padding: 20,
    borderRadius: 15,
    marginBottom: 15,
    elevation: 5,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  cardText: {
    fontSize: 18,
    color: "#555",
  },
});