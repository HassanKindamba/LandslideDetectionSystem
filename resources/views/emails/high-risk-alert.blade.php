<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">

    <div style="max-width:600px; margin:0 auto; background:white; border-radius:10px; overflow:hidden;">

        <div style="background:#c62828; color:white; padding:20px; text-align:center;">
            <h2 style="margin:0;">⚠️ HIGH RISK ALERT</h2>
        </div>

        <div style="padding:25px;">
            <p>Angalizo: Mfumo wa Landslide Detection umegundua hali ya HATARI KUBWA (HIGH RISK).</p>

            <table style="width:100%; border-collapse:collapse; margin-top:15px;">
                <tr>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><b>Soil Moisture</b></td>
                    <td style="padding:10px; border-bottom:1px solid #eee;">{{ $sensorData->soil_moisture }}%</td>
                </tr>
                <tr>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><b>Vibration</b></td>
                    <td style="padding:10px; border-bottom:1px solid #eee;">{{ $sensorData->vibration == 1 ? 'Detected' : 'Normal' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><b>Tilt</b></td>
                    <td style="padding:10px; border-bottom:1px solid #eee;">{{ $sensorData->tilt == 1 ? 'Detected' : 'Normal' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px;"><b>Time</b></td>
                    <td style="padding:10px;">{{ $sensorData->created_at->format('d M Y H:i:s') }}</td>
                </tr>
            </table>

            <p style="margin-top:20px; color:#c62828; font-weight:bold;">
                Tafadhali kagua eneo mara moja.
            </p>
        </div>

    </div>

</body>
</html>