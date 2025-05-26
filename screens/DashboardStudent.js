import React, { useContext } from "react";
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  ScrollView,
  Alert,
} from "react-native";
import { useNavigation } from "@react-navigation/native";
import { AuthContext } from "../context/AuthContext";

export default function DashboardStudent() {
  const navigation = useNavigation();
  const { logout } = useContext(AuthContext);

  const modules = [
    { title: "📅 Takvim", screen: "Calendar" },
    { title: "🧠 Çalışma Programı", screen: "StudyPlan" },
    { title: "📈 Sınav Analizleri", screen: "ExamAnalysis" },
    { title: "📝 Notlarım", screen: "Notes" },
    { title: "🔔 Bildirimler", screen: "Notifications" },
  ];

  const handleLogout = async () => {
    Alert.alert("Çıkış Yap", "Çıkış yapmak istediğine emin misin?", [
      { text: "İptal", style: "cancel" },
      {
        text: "Evet",
        onPress: async () => {
          await logout();
          navigation.replace("Login");
        },
      },
    ]);
  };

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

      <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
        <Text style={styles.logoutText}>🚪 Çıkış Yap</Text>
      </TouchableOpacity>
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
  logoutButton: {
    marginTop: 20,
    padding: 15,
    borderRadius: 12,
    backgroundColor: "#ff4d4d",
    alignItems: "center",
  },
  logoutText: {
    color: "#fff",
    fontWeight: "bold",
    fontSize: 16,
  },
});