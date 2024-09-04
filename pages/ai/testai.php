<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script>
    // สร้างโมเดล
    const model = tf.sequential();

    // เพิ่มเลเยอร์
    model.add(tf.layers.dense({
        units: 10,
        inputShape: [2],
        activation: 'relu'
    }));
    model.add(tf.layers.dense({
        units: 1
    }));

    // คอมไพล์โมเดล
    model.compile({
        optimizer: 'sgd',
        loss: 'meanSquaredError'
    });

    // สร้างข้อมูลการฝึก
    const xs = tf.tensor2d([
        [1, 2],
        [2, 3],
        [3, 4]
    ], [3, 2]);
    const ys = tf.tensor2d([3, 5, 7], [3, 1]);

    // ฝึกโมเดล
    model.fit(xs, ys, {
        epochs: 10
    }).then(() => {
        // ใช้โมเดล
        model.predict(tf.tensor2d([
            [4, 5]
        ], [1, 2])).print();
    });
</script>