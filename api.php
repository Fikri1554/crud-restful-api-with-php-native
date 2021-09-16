<?php
    //memasukan file koneksi
    include "koneksi.php";


    if(function_exists($_GET['function'])){
        $_GET['function']();
    }

    //mengambil semua data mahasiswa

    function ambil_dataMahasiswa(){
        global $conn;
        $query = $conn->query("SELECT * FROM mahasiswa");
        while($row=mysqli_fetch_object($query))
       {
           $data[] = $row;
       }

       $response = array(
            'status' => 200,
            'Message' => "Success",
            'data' => $data
        );

        header('Content-type: application/json');
        echo json_encode($response);
    }
    
    //mengambil data mahasiswa berdasarkan id
    function get_idMahasiswa()
    {
        global $conn;
        
        if(!empty($_GET["id"]))
        {
            $id = $_GET["id"];
        }   
        $query = "SELECT * FROM mahasiswa WHERE id_mahasiswa=$id";
        $hasil = $conn->query($query);
        while($row = mysqli_fetch_object($hasil))
        {
            $data[] = $row;
        }

        if($data){
            $response = array(
                'status' => 200,
                'Message' => "Success",
                'data' => $data
            );
        }else
        {
            $response = array(
                'status' => 404,
                'Message' => "Data not found"
            );
        }

        header('Content-type: application/json');
        echo json_encode($response);
    }

    //menambahkan data

    function tambah_mahasiswa()
    {
        global $conn;

        $check = array(
            'id_mahasiswa' => '',
            'nama_mahasiswa' => '',
            'jurusan' => '',
            'email' => '',
            'kelas_mahasiswa' => ''
        );
        $check_match = count(array_intersect_key($_POST, $check));
        
        if($check_match == count($check)){
         
            $result = mysqli_query($conn, "INSERT INTO mahasiswa SET
            id_mahasiswa = '$_POST[id_mahasiswa]',
            nama_mahasiswa = '$_POST[nama_mahasiswa]',
            jurusan = '$_POST[jurusan]',
            email = '$_POST[email]',
            kelas_mahasiswa = '$_POST[kelas_mahasiswa]'");
            
            if($result)
            {
               $response=array(
                  'status' => 200,
                  'message' =>'Insert Success'
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Insert Failed.'
               );
            }
        }else
        {
         $response=array(
                  'status' => 0,
                  'message' =>'Wrong Parameter'
         );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    //update mahasiswa
    function update_mahasiswa()
    {
        //fungsi global merupakan sebuah fungsi untuk memanggil variabel yang berada pada file koneksi.php
        global $conn;
        if (!empty($_GET["id"])) 
        {
             $id = $_GET["id"];      
        }   
        $check = array(
            'nama_mahasiswa' => '',
            'jurusan' => '',
            'email' => '',
            'kelas_mahasiswa' => ''
        );

        $check_match = count(array_intersect_key($_POST, $check));        
         
        if($check_match == count($check))
        {
         
            $hasil = mysqli_query($conn, "UPDATE mahasiswa SET             
            nama_mahasiswa = '$_POST[nama_mahasiswa]',
            jurusan = '$_POST[jurusan]',
            email= '$_POST[email]',
            kelas_mahasiswa = '$_POST[kelas_mahasiswa]' WHERE id_mahasiswa = $id");
         
            if($hasil)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Update Success'                  
               );
            }
            else
            {
               $response=array(
                'status' => 0,
                'message' =>'Update Failed'                  
               );
            }
        }
         else
        {
            $response=array(
                'status' => 0,
                'message' =>'Wrong Parameter',
                'data'=> $id
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    //hapus data mahasiswa
    function hapus_dataMahasiswa()
    {
     global $conn;
      $id = $_GET['id'];
      $query = "DELETE FROM mahasiswa WHERE id_mahasiswa=".$id;
      if(mysqli_query($conn, $query))
      {
        $response=array(
            'status' => 1,
            'message' =>'Delete Success'
        );
      }
      else
      {
        $response=array(
            'status' => 0,
            'message' =>'Delete Fail.'
        );
      }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>