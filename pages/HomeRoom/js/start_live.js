document
  .getElementById("startLiveButton")
  .addEventListener("click", async () => {
    try {
      // รับสตรีมจากการแชร์หน้าจอ
      const stream = await navigator.mediaDevices.getDisplayMedia({
        video: true,
      });
      document.getElementById("screenVideo").srcObject = stream;

      // แสดงปุ่มหยุดการแชร์และซ่อนปุ่มเริ่ม
      document.getElementById("stopShareButton").classList.remove("hidden");
      document.getElementById("startLiveButton").classList.add("hidden");
    } catch (err) {
      console.error("Error sharing screen:", err);
    }
  });

document.getElementById("stopShareButton").addEventListener("click", () => {
  const stream = document.getElementById("screenVideo").srcObject;
  if (stream) {
    // หยุดการแชร์หน้าจอ
    stream.getTracks().forEach((track) => track.stop());
    document.getElementById("screenVideo").srcObject = null;

    // แสดงปุ่มเริ่มการแชร์หน้าจอและซ่อนปุ่มหยุด
    document.getElementById("stopShareButton").classList.add("hidden");
    document.getElementById("startLiveButton").classList.remove("hidden");
  }
});
