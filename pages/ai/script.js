// สร้างโมเดล
const model = tf.sequential();

// เพิ่มเลเยอร์
model.add(tf.layers.dense({ units: 20, activation: "relu" }));
model.add(tf.layers.dense({ units: 10, activation: "relu" }));
model.add(tf.layers.dense({ units: 1 }));

// คอมไพล์โมเดล
model.compile({ optimizer: "sgd", loss: "meanSquaredError" });

// ข้อมูลการฝึกที่ขยาย
const xs = tf.tensor2d(
  [
    [1, 2],
    [2, 3],
    [3, 4],
    [4, 5],
    [5, 6],
    [6, 7],
    [7, 8],
    [8, 9],
    [9, 10],
    [10, 11],
  ],
  [10, 2]
);

const ys = tf.tensor2d([3, 5, 7, 9, 11, 13, 15, 17, 19, 21], [10, 1]);

// ฟังก์ชันสำหรับฝึกโมเดล
async function trainModel() {
  await model.fit(xs, ys, {
    epochs: 50,
    batchSize: 5,
    validationSplit: 0.1,
  });
  document
    .getElementById("predict-form")
    .addEventListener("submit", async (event) => {
      event.preventDefault();

      const input1 = parseFloat(document.getElementById("input1").value);
      const input2 = parseFloat(document.getElementById("input2").value);

      const output = model.predict(tf.tensor2d([[input1, input2]], [1, 2]));
      const result = output.dataSync()[0];

      document.getElementById(
        "prediction-result"
      ).textContent = `Prediction: ${result}`;
    });
}
async function saveModel() {
  await model.save("localstorage://my-model");
}
async function loadModel() {
  model = await tf.loadLayersModel("localstorage://my-model");
}
// ฟังก์ชันสำหรับคาดการณ์
async function predict() {
  const output = model.predict(tf.tensor2d([[4, 5]], [1, 2]));
  output.print();

  // แสดงผลลัพธ์การคาดการณ์
  const result = output.dataSync()[0];
  document.getElementById(
    "prediction-result"
  ).textContent = `Prediction: ${result}`;
}

// เชื่อมต่อปุ่มกับฟังก์ชัน
document.getElementById("train-button").addEventListener("click", trainModel);
document.getElementById("predict-button").addEventListener("click", predict);
