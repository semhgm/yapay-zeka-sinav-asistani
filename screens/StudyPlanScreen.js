import React, { useState } from "react";
import {
  View,
  Text,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
  TextInput,
} from "react-native";

const sampleData = {
  Pazartesi: [
    {
      id: 1,
      subject: "Matematik",
      title: "Test 12 çöz",
      duration: 90,
      is_completed: false,
    },
    {
      id: 2,
      subject: "Fizik",
      title: "Konu tekrar et",
      duration: 60,
      is_completed: true,
    },
  ],
  Salı: [
    {
      id: 3,
      subject: "Kimya",
      title: "Video izle",
      duration: 45,
      is_completed: false,
    },
  ],
};

export default function StudyPlanScreen() {
  const [selectedDay, setSelectedDay] = useState("Pazartesi");
  const [subject, setSubject] = useState("");
  const [title, setTitle] = useState("");
  const [duration, setDuration] = useState("");

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.header}>Görev Ekle</Text>

      <View style={styles.inputContainer}>
        <Text style={styles.label}>Gün Seç</Text>
        <TextInput
          style={styles.input}
          value={selectedDay}
          onChangeText={setSelectedDay}
          placeholder="Örn: Pazartesi"
        />

        <Text style={styles.label}>Ders</Text>
        <TextInput
          style={styles.input}
          value={subject}
          onChangeText={setSubject}
          placeholder="Örn: Matematik"
        />

        <Text style={styles.label}>Görev Başlığı</Text>
        <TextInput
          style={styles.input}
          value={title}
          onChangeText={setTitle}
          placeholder="Örn: Test 12 çöz"
        />

        <Text style={styles.label}>Çalışma Süresi (dk)</Text>
        <TextInput
          style={styles.input}
          value={duration}
          onChangeText={setDuration}
          placeholder="Örn: 120"
          keyboardType="numeric"
        />

        <TouchableOpacity style={styles.saveButton}>
          <Text style={styles.saveButtonText}>Kaydet</Text>
        </TouchableOpacity>
      </View>

      <Text style={styles.sectionHeader}>Çalışma Planım</Text>

      {Object.keys(sampleData).map((day) => (
        <View key={day} style={styles.daySection}>
          <Text style={styles.dayTitle}>{day}</Text>

          {sampleData[day].map((task) => (
            <View key={task.id} style={styles.taskCard}>
              <Text style={styles.taskTitle}>
                {task.title} ({task.duration} dk)
              </Text>
              <Text style={styles.taskSubject}>{task.subject}</Text>

              <View style={styles.buttonRow}>
                <TouchableOpacity
                  style={[styles.button, styles.completeButton]}
                >
                  <Text style={styles.buttonText}>
                    {task.is_completed ? "Tamamlandı" : "Tamamla"}
                  </Text>
                </TouchableOpacity>
                <TouchableOpacity style={[styles.button, styles.deleteButton]}>
                  <Text style={styles.buttonText}>Sil</Text>
                </TouchableOpacity>
              </View>
            </View>
          ))}
        </View>
      ))}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { padding: 20, backgroundColor: "#fff" },
  header: { fontSize: 24, fontWeight: "bold", marginBottom: 10 },
  sectionHeader: { fontSize: 20, fontWeight: "bold", marginTop: 30, marginBottom: 10 },
  inputContainer: { marginBottom: 20 },
  label: { fontWeight: "600", marginBottom: 5, marginTop: 10 },
  input: {
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 8,
    padding: 10,
  },
  saveButton: {
    backgroundColor: "#007bff",
    paddingVertical: 10,
    borderRadius: 8,
    marginTop: 15,
    alignItems: "center",
  },
  saveButtonText: { color: "#fff", fontWeight: "bold" },
  daySection: { marginBottom: 25 },
  dayTitle: { fontSize: 18, fontWeight: "600", marginBottom: 10 },
  taskCard: {
    backgroundColor: "#f2f2f2",
    borderRadius: 10,
    padding: 15,
    marginBottom: 10,
  },
  taskTitle: { fontSize: 16, fontWeight: "500" },
  taskSubject: { fontSize: 14, color: "gray", marginTop: 5 },
  buttonRow: {
    flexDirection: "row",
    marginTop: 10,
    justifyContent: "flex-end",
    gap: 10,
  },
  button: {
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 6,
  },
  completeButton: { backgroundColor: "#4CAF50" },
  deleteButton: { backgroundColor: "#f44336" },
  buttonText: { color: "#fff", fontWeight: "bold" },
});