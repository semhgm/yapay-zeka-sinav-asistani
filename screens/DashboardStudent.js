import React, { useEffect, useState } from 'react';
import { View, Text, FlatList } from 'react-native';
import { getStudentProgress } from '../services/api';
import { SafeAreaView } from 'react-native-safe-area-context';

export default function DashboardStudent() {
  const [progress, setProgress] = useState([]);

  useEffect(() => {
    getStudentProgress(1).then(setProgress); // örnek user_id = 1
  }, []);

  return (
    <SafeAreaView>
    <View style={{ padding: 20 }}>
        <Text style={{ fontSize: 22, fontWeight: 'bold' }}>İlerleme Durumu</Text>
        <FlatList
          data={progress}
          keyExtractor={(item) => item.id.toString()}
          renderItem={({ item }) => (
            <Text>📚 {item.exam_id} - {item.correct_count} doğru, {item.wrong_count} yanlış</Text>
          )}
        />
      </View>
  </SafeAreaView>
   
  );
}