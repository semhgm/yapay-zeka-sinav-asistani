<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicsSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'Anlam bilgisi – cümlede anlam',
            'Paragraf – ana düşünce, yardımcı düşünce',
            'Paragraf – yapısı ve akışı',
            'Anlatım biçimleri ve düşünceyi geliştirme yolları',
            'Sözcükte anlam',
            'Cümlede anlam ilişkileri (koşul, öneri vs.)',
            'Yazım kuralları',
            'Noktalama işaretleri',
            'Sözcük türleri',
            'Cümle türleri',
            'Paragrafta yapı/bağlantı/sıralama',
            'Anlatım bozukluğu',
            'Orta Asya Türk tarihi',
            'Kutadgu Bilig’den devlet anlayışı',
            'Anadolu uygarlıkları',
            'Osmanlı sosyal yapısı',
            'Islahatlar',
            'Nüfus piramitleri',
            'İklim özellikleri',
            'Doğal afetler',
            'Bilgi felsefesi (epistemoloji)',
            'Bilim felsefesi – Rönesans',
            'Varoluşçuluk (Sartre)',
            'Ahlak kuralları',
            'Güncel çevre sorunları ve dini yaklaşım',
            'Sayı problemleri',
            'Kesir problemleri',
            'Yüzde – oran orantı',
            'Üslü ve köklü sayılar',
            'Denklem çözme',
            'Veri – medyan, ortalama',
            'Geometri problemleri',
            'Mantık ve olasılık',
            'Fonksiyonlar',
            'Eylemsizlik',
            'Hız, sürat, yer değiştirme',
            'Isı alışverişi',
            'Kimyasal tepkimeler – yanma',
            'Asit-baz çözeltileri',
            'Kimyasal bağlar',
            'Hücre yapıları',
            'Kalıtım ve genetik kavramlar',
            'Ekosistem – çevresel etkiler',
        ];

        foreach ($topics as $topic) {
            Topic::firstOrCreate(['name' => $topic]);
        }
    }
}
