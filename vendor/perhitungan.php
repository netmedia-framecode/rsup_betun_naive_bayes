<?php

class Perhitungan
{

  public function bayes($penyakit_all, $gejala_all, $gejala_terpilih)
  {

    //langkah 1

    // menentukan penyakit yang muncul berdasarkan data latih			

    // menyusun array penyakit
    $penyakit_all[0] = [
      'kode' => 'P001',
      'nama' => 'Demam Berdarah Dengue'
    ];
    $penyakit_all[1] = [
      'kode' => 'P002',
      'nama' => 'Diare Akut'
    ];
    $penyakit_all[2] = [
      'kode' => 'P003',
      'nama' => 'Tuberkolosis Paru'
    ];
    $penyakit_all[3] = [
      'kode' => 'P004',
      'nama' => 'Anemia'
    ];

    //menyusun array gejala
    $gejala_all[0] = [
      'kode' => 'G01',
      'nama' => 'Nyeri kepala dan demam',
      'probabilitas' => 'P001'
    ];
    $gejala_all[1] = [
      'kode' => 'G02',
      'nama' => 'Nyeri dibelakang bola mata',
      'probabilitas' => 'P001'
    ];
    $gejala_all[2] = [
      'kode' => 'G03',
      'nama' => 'Nyeri otot',
      'probabilitas' => 'P001'
    ];
    $gejala_all[3] = [
      'kode' => 'G04',
      'nama' => 'Mual  dan muntah',
      'probabilitas' => 'P001'
    ];
    $gejala_all[4] = [
      'kode' => 'G05',
      'nama' => 'Ruam atau bintik merah pada kulit',
      'probabilitas' => 'P001'
    ];
    $gejala_all[5] = [
      'kode' => 'G06',
      'nama' => 'Nyeri Perut',
      'probabilitas' => 'P001'
    ];
    $gejala_all[6] = [
      'kode' => 'G07',
      'nama' => 'Mimisan dan Gusi Berdarah',
      'probabilitas' => 'P001'
    ];
    $gejala_all[7] = [
      'kode' => 'G08',
      'nama' => 'BAB Carir',
      'probabilitas' => 'P002'
    ];
    $gejala_all[8] = [
      'kode' => 'G09',
      'nama' => 'Tidak nafsu makan',
      'probabilitas' => 'P002'
    ];
    $gejala_all[9] = [
      'kode' => 'G010',
      'nama' => 'Mual dan Muntah',
      'probabilitas' => 'P002'
    ];
    $gejala_all[10] = [
      'kode' => 'G011',
      'nama' => 'Kram pada perut',
      'probabilitas' => 'P002'
    ];
    $gejala_all[11] = [
      'kode' => 'G012',
      'nama' => 'Perut mulas atau kembung',
      'probabilitas' => 'P002'
    ];
    $gejala_all[12] = [
      'kode' => 'G013',
      'nama' => 'Dorongan untuk BAB meningkat',
      'probabilitas' => 'P002'
    ];
    $gejala_all[13] = [
      'kode' => 'G014',
      'nama' => 'Tidak mampu menahan BAB',
      'probabilitas' => 'P002'
    ];
    $gejala_all[14] = [
      'kode' => 'G015',
      'nama' => 'Demam',
      'probabilitas' => 'P002'
    ];
    $gejala_all[15] = [
      'kode' => 'G016',
      'nama' => 'Bercak darah pada fases',
      'probabilitas' => 'P002'
    ];
    $gejala_all[16] = [
      'kode' => 'G017',
      'nama' => 'Dehidrasi',
      'probabilitas' => 'P002'
    ];
    $gejala_all[17] = [
      'kode' => 'G018',
      'nama' => 'Berat badan anak dengan gejal TBC Paru turun atau tidak naik dalan 2 bulan terahir',
      'probabilitas' => 'P003'
    ];
    $gejala_all[18] = [
      'kode' => 'G19',
      'nama' => 'Demam lama lebih dari 2 minggu dan atau berulang tanpa sebab',
      'probabilitas' => 'P003'
    ];
    $gejala_all[19] = [
      'kode' => 'G020',
      'nama' => 'Suhu umumnya tidak tinggi',
      'probabilitas' => 'P003'
    ];
    $gejala_all[20] = [
      'kode' => 'G021',
      'nama' => 'Batuk lama lebih dari 2 minggu yang makin lama makin parah yang tidak membaik dengan pemberian antibiotik',
      'probabilitas' => 'P003'
    ];
    $gejala_all[21] = [
      'kode' => 'G022',
      'nama' => 'Badan lemas/lesu sehingga tidak aktif bermain',
      'probabilitas' => 'P003'
    ];
    $gejala_all[22] = [
      'kode' => 'G023',
      'nama' => 'Detak jantung meningkat (takikardia)',
      'probabilitas' => 'P004'
    ];
    $gejala_all[24] = [
      'kode' => 'G024',
      'nama' => 'Sesak napas atau kesulitas menarik napas (dyspnea)',
      'probabilitas' => 'P004'
    ];
    $gejala_all[25] = [
      'kode' => 'G026',
      'nama' => 'Kekurangan energi atau mudah lelah (kelelahan)',
      'probabilitas' => 'P004'
    ];
    $gejala_all[26] = [
      'kode' => 'G027',
      'nama' => 'Pusing atau vertigo, terutama saat berdiri',
      'probabilitas' => 'P004'
    ];
    $gejala_all[27] = [
      'kode' => 'G028',
      'nama' => 'Sakit kepala',
      'probabilitas' => 'P004'
    ];
    $gejala_all[28] = [
      'kode' => 'G029',
      'nama' => 'Mudah marah',
      'probabilitas' => 'P004'
    ];
    $gejala_all[29] = [
      'kode' => 'G030',
      'nama' => 'Lidah sakit atau bengkak (glositis)',
      'probabilitas' => 'P004'
    ];
    $gejala_all[30] = [
      'kode' => 'G031',
      'nama' => 'Penyakit kuning atau kulit, mata, dan mulut terlihat menguning',
      'probabilitas' => 'P004'
    ];
    $gejala_all[31] = [
      'kode' => 'G032',
      'nama' => 'Pembesaran limpa atau hari (splenomegali, hepatomegali)',
      'probabilitas' => 'P004'
    ];
    $gejala_all[32] = [
      'kode' => 'G033',
      'nama' => 'Pertumbuahan dan perkembangan yang  lambat atau tertunda',
      'probabilitas' => 'P004'
    ];
    $gejala_all[33] = [
      'kode' => 'G034',
      'nama' => 'Siklus haid tidak teratur',
      'probabilitas' => 'P004'
    ];
    $gejala_all[34] = [
      'kode' => 'G035',
      'nama' => 'Menstruasi tidak ada atau tertunda (amenore)',
      'probabilitas' => 'P004'
    ];

    //menyusun array gejala terpilih
    $gejala_terpilih[0] = $gejala_all[3];
    $gejala_terpilih[1] = $gejala_all[4];
    $gejala_terpilih[2] = $gejala_all[14];
    $gejala_terpilih[3] = $gejala_all[28];

    //langkah ke 2

    //Menghitung nilai Probabilitas penyakit dan gejala		

    $probabilitas_penyakit_gejala = [];

    foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

      $prob_gejala[$key_penyakit_all] = 0;
      foreach ($gejala_all as $key_gejala_all => $value_gejala_all) {

        if ($value_gejala_all['probabilitas'] == $value_penyakit_all['kode']) {
          $prob_gejala[$key_penyakit_all]++;
        }
      }

      $probabilitas_penyakit_gejala[$key_penyakit_all] = $prob_gejala[$key_penyakit_all] / count($gejala_all);
    }

    //langkah ke 3 

    // Menghitung nilai bayes berdasarkan probabilitas penyakit dan gejala yang timbul 				

    $nilai_bayes_probabilitas_penyakit_gejala_timbul = [];
    foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

      $nilai_bayes_probabilitas_penyakit_gejala_timbul[$key_penyakit_all] = $probabilitas_penyakit_gejala[$key_penyakit_all] / count($gejala_terpilih);
    }

    //langkah ke 4	

    // Proses  1 :					

    //Menentukan nilai nc untuk setiap class	

    $nilai_n_class = [];
    $n = [];
    foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

      foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

        $temp = false;

        foreach ($gejala_all as $key_gejala_all => $value_gejala_all) {

          if ($value_gejala_terpilih['probabilitas'] == $value_gejala_all['probabilitas'] && $value_gejala_all['probabilitas'] == $value_penyakit_all['kode']) {

            $temp = true;
          }
        }

        if ($temp == true) {

          $nc[$key_penyakit_all][$key_gejala_terpilih] = 1;
        } else {

          $nc[$key_penyakit_all][$key_gejala_terpilih] = 0;
        }
      }

      $cocok = false;
      // dd($nc);
      foreach ($nc[$key_penyakit_all] as $key_nc => $value_nc) {

        if ($value_nc == 1) {

          $cocok = true;
        }
      }

      if ($cocok == true) {

        $n[$key_penyakit_all] = 1;
      } else {

        $n[$key_penyakit_all] = 0;
      }

      $nilai_n_class[$key_penyakit_all] = [
        'class' => $value_penyakit_all['nama'],
        'n' => $n[$key_penyakit_all],
        'p' => 1 / count($gejala_terpilih),
        'm' => count($gejala_all),
      ];
      $nilai_n_class[$key_penyakit_all]['nc'] = $nc[$key_penyakit_all];
    }

    //Proses 2 : 	

    // menghitung nilai P(ai|vj) dengan menghitung nilai P(vj)					

    $nilai_p_a_v_p = [];
    foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

      foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

        $nilai_p_a_v_p[$key_penyakit_all]['class'] = $value_penyakit_all['kode'];

        $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['kode_gejala'] = $value_gejala_terpilih['kode'];

        $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'] = ($nilai_n_class[$key_penyakit_all]['nc'][$key_gejala_terpilih] + $nilai_n_class[$key_penyakit_all]['m'] * $nilai_n_class[$key_penyakit_all]['p']) / ($nilai_n_class[$key_penyakit_all]['nc'][$key_gejala_terpilih] + $nilai_n_class[$key_penyakit_all]['m']);
      }
    }

    // Proses 3  :				
    // Menghitung P(ai|vj) x P(vj) untuk tiap v	
    $nilai_p_a_v_v = [];
    foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

      $total_nilai_p_a_v_p[$key_penyakit_all] = 0;
      foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

        if ($key_gejala_terpilih == 0) {
          $total_nilai_p_a_v_p[$key_penyakit_all] = $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'];
        }

        $total_nilai_p_a_v_p[$key_penyakit_all] = $total_nilai_p_a_v_p[$key_penyakit_all] * $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'];
      }

      $nilai_p_a_v_v[$key_penyakit_all]['class'] = $value_penyakit_all['kode'];
      $nilai_p_a_v_v[$key_penyakit_all]['v_max'] = $nilai_n_class[$key_penyakit_all]['p'] * $total_nilai_p_a_v_p[$key_penyakit_all];
    }

    // Proses 4 : 						
    // Menentukan hasil klasifikasi yaitu v yang memiliki hasil perkalian yang terbesar						

    $nilai_p_a_v_v_rsort = $this->bubble_sort($nilai_p_a_v_v, 'v_max');

    return $nilai_p_a_v_v_rsort;
  }

  function bubble_sort($arr, $key)
  {
    $size = count($arr) - 1;

    for ($i = 0; $i < $size; $i++) {

      for ($j = 0; $j < $size - $i; $j++) {

        $k = $j + 1;

        if ($arr[$k][$key] > $arr[$j][$key]) {

          list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
        }
      }
    }

    return $arr;
  }
}
