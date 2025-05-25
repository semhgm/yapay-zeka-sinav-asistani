import React from "react";
import {
  View,
  Text,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
} from "react-native";

const sampleAnalysis = {
  exam_name: "TYT Genel 01",
  correct: 5,
  wrong: 14,
  blank: 0,
  net: 1.5,
  details: [
    {
      id: 1,
      question: "Fotoğrafa göre doğru cevap nedir?",
      topic: "Sayı Problemleri",
      answer: "C",
      correct_answer: "C",
    },
    {
      id: 2,
      question: "Anlam bilgisi – cümlede anlam",
      topic: "Cümlede Anlam",
      answer: "A",
      correct_answer: "B",
    },
    {
      id: 3,
      question: "Sözcükte anlam",
      topic: "Sözcükte Anlam",
      answer: "B",
      correct_answer: "A",
    },
  ],
};

export default function ExamAnalysisScreen() {
  const { exam_name, correct, wrong, blank, net, details } = sampleAnalysis;

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>{exam_name}</Text>

      <View style={styles.summary}>
        {[
          { label: "Doğru", value: correct },
          { label: "Yanlış", value: wrong },
          { label: "Boş", value: blank },
          { label: "Net", value: net },
        ].map((item, idx) => (
          <Text key={idx} style={styles.summaryText}>
            {item.label}: {item.value}
          </Text>
        ))}
      </View>

      <Text style={styles.subTitle}>📝 Detaylı Cevap Analizi</Text>

      {details.map((item) => {
        const isCorrect = item.answer === item.correct_answer;
        return (
          <View key={item.id} style={styles.card}>
            <Text style={styles.question}>{item.question}</Text>
            <Text style={styles.detail}>Konu: {item.topic}</Text>
            <Text style={styles.detail}>Cevabın: {item.answer}</Text>
            <Text style={styles.detail}>Doğru Cevap: {item.correct_answer}</Text>
            <Text style={[styles.status, isCorrect ? styles.correct : styles.wrong]}>
              {isCorrect ? "✔ Doğru" : "✖ Yanlış"}
            </Text>
          </View>
        );
      })}

      <TouchableOpacity style={styles.aiButton}>
        <Text style={styles.aiButtonText}>🧠 Yapay Zeka ile Yorumla</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { padding: 20, backgroundColor: "#fff" },
  title: { fontSize: 22, fontWeight: "bold", marginBottom: 15 },
  summary: { flexDirection: "row", flexWrap: "wrap", marginBottom: 20 },
  summaryText: {
    marginRight: 15,
    fontSize: 14,
    backgroundColor: "#eee",
    padding: 6,
    borderRadius: 8,
    marginBottom: 6,
  },
  subTitle: { fontSize: 18, fontWeight: "600", marginBottom: 10 },
  card: {
    backgroundColor: "#f4f4f4",
    borderRadius: 10,
    padding: 15,
    marginBottom: 15,
  },
  question: { fontWeight: "bold", marginBottom: 5, fontSize: 15 },
  detail: { fontSize: 14, marginBottom: 2 },
  status: {
    marginTop: 8,
    paddingVertical: 4,
    paddingHorizontal: 8,
    borderRadius: 5,
    alignSelf: "flex-start",
    fontWeight: "bold",
  },
  correct: { backgroundColor: "#4CAF50", color: "#fff" },
  wrong: { backgroundColor: "#f44336", color: "#fff" },
  aiButton: {
    marginTop: 20,
    backgroundColor: "#007bff",
    padding: 12,
    borderRadius: 10,
    alignItems: "center",
  },
  aiButtonText: { color: "#fff", fontWeight: "bold" },
});