import React from "react";
import {
  View,
  Text,
  ScrollView,
  StyleSheet,
  TouchableOpacity,
} from "react-native";

const sampleNotes = [
  {
    id: 1,
    title: "İlk Not",
    content: "Bu bir örnek not içeriğidir. Ders çalışmayı unutma!",
    tag: "matematik",
    pdf_path: null,
  },
  {
    id: 2,
    title: "ders çalış",
    content: "eve git ders çalış matematik",
    tag: "türkçe",
    pdf_path: "sample.pdf",
  },
];

export default function NotesScreen() {
  return (
    <ScrollView style={styles.container}>
      <TouchableOpacity style={styles.addButton}>
        <Text style={styles.addButtonText}>+ Yeni Not Ekle</Text>
      </TouchableOpacity>

      {sampleNotes.map((note) => (
        <View key={note.id} style={styles.noteCard}>
          <Text style={styles.noteTitle}>{note.title}</Text>

          {note.tag && <Text style={styles.tag}>{note.tag}</Text>}

          <Text style={styles.contentPreview} numberOfLines={2}>
            {note.content}
          </Text>

          {note.pdf_path && (
            <TouchableOpacity style={styles.pdfButton}>
              <Text style={styles.pdfButtonText}>📄 PDF Görüntüle</Text>
            </TouchableOpacity>
          )}
        </View>
      ))}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { padding: 20, backgroundColor: "#fff" },
  addButton: {
    backgroundColor: "#28a745",
    padding: 12,
    borderRadius: 8,
    marginBottom: 20,
    alignItems: "center",
  },
  addButtonText: { color: "#fff", fontWeight: "bold" },
  noteCard: {
    backgroundColor: "#f4f4f4",
    borderRadius: 10,
    padding: 15,
    marginBottom: 15,
  },
  noteTitle: { fontSize: 16, fontWeight: "bold", marginBottom: 5 },
  tag: {
    alignSelf: "flex-start",
    backgroundColor: "#e0e0e0",
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 10,
    fontSize: 12,
    color: "#333",
    marginBottom: 6,
  },
  contentPreview: { fontSize: 14, color: "#333" },
  pdfButton: {
    marginTop: 10,
    backgroundColor: "#007bff",
    padding: 8,
    borderRadius: 6,
    alignSelf: "flex-start",
  },
  pdfButtonText: { color: "#fff", fontWeight: "600" },
});