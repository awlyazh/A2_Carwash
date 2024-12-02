<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Pelanggan; // Ganti dengan model pelanggan Anda

class WhatsAppController extends Controller
{
    public function sendWhatsApp($id)
    {
        // Ambil data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Pesan WhatsApp yang akan dikirim
        $message = "Halo, {$pelanggan->nama}. Terima kasih telah menggunakan layanan kami di A2 Carwash!";

        // Kirim menggunakan API Fonnte
        $client = new Client();
        try {
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => 'YOUR_FONNTE_API_KEY', // Ganti dengan API Key Anda
                ],
                'form_params' => [
                    'target' => $pelanggan->no_hp, // Nomor HP pelanggan
                    'message' => $message,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if ($result['status'] === true) {
                return redirect()->back()->with('success', 'Pesan berhasil dikirim ke pelanggan.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim pesan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
