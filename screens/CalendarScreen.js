import React, { useState } from "react";
import { View, Text, StyleSheet } from "react-native";
import { Calendar } from 'react-native-calendars';

export default function CalendarScreen() {
  const [selectedDate, setSelectedDate] = useState('');
  const [markedDates, setMarkedDates] = useState({
    '2024-07-20': { selected: true, marked: true, selectedDotColor: 'orange' },
    '2024-07-22': { marked: true },
    '2024-07-24': { marked: true, dotColor: 'red', activeOpacity: 0 },
    '2024-07-25': { disabled: true, disableTouchEvent: true }
  });

  // Dummy events for demonstration
  const events = {
    '2024-07-20': ['Matematik Çalışması', 'Fizik Ders Notları'],
    '2024-07-22': ['Tarih Tekrarı'],
    '2024-07-24': ['Deneme Sınavı', 'Biyoloji Okuma'],
  };

  return (
    <View style={styles.container}>
      <Text style={styles.heading}>Takvim</Text>
      <Calendar
        onDayPress={(day) => {
          setSelectedDate(day.dateString);
          // You can add logic here to display events for the selected day
          console.log('selected day', day);
        }}
        markedDates={markedDates}
        // Specify style for calendar container element.
        style={styles.calendar}
        // Specify theme properties to override specific styles for calendar parts.
        theme={{
          selectedDayBackgroundColor: '#4a90e2',
          selectedDayTextColor: '#ffffff',
          todayTextColor: '#4a90e2',
          arrowColor: '#4a90e2',
          indicatorColor: '#4a90e2',
          textDayFontWeight: '300',
          textMonthFontWeight: 'bold',
          textDayHeaderFontWeight: '300',
          textDayFontSize: 16,
          textMonthFontSize: 16,
          textDayHeaderFontSize: 16,
        }}
      />
      {selectedDate && events[selectedDate] && (
        <View style={styles.eventsContainer}>
          <Text style={styles.eventsHeading}>Seçilen Güne Ait Etkinlikler:</Text>
          {events[selectedDate].map((event, index) => (
            <Text key={index} style={styles.eventText}>• {event}</Text>
          ))}
        </View>
      )}
       {!selectedDate && (
        <View style={styles.eventsContainer}>
          <Text style={styles.eventsHeading}>Bugünün Etkinlikleri:</Text>
           {events[new Date().toISOString().split('T')[0]] ? (
              events[new Date().toISOString().split('T')[0]].map((event, index) => (
                <Text key={index} style={styles.eventText}>• {event}</Text>
              ))
            ) : (
              <Text style={styles.eventText}>Bugün için etkinlik bulunmamaktadır.</Text>
            )}
        </View>
      )}

    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f8f8f8',
  },
  heading: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
    color: '#333',
  },
  calendar: {
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 10,
    padding: 5,
    marginBottom: 20,
  },
  eventsContainer: {
    marginTop: 20,
    padding: 15,
    backgroundColor: '#fff',
    borderRadius: 10,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.05,
    shadowRadius: 3,
    elevation: 3,
  },
  eventsHeading: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
    color: '#333',
  },
  eventText: {
    fontSize: 16,
    marginBottom: 5,
    color: '#555',
  },
});