document.addEventListener("DOMContentLoaded", () => {
    const tigaLingkaranPertama = document.querySelector(".tiga-lingkaran-pertama"),
          persenGajiLingkaran = document.querySelector(".persen-gaji-lingkaran");

    let persenStartLingkaranPertama = 0,
        persenEndLingkaranPertama = 65,
        speedLingkaranPertama = 20;

    let intervalLingkaranPertama = setInterval(() => {
        persenStartLingkaranPertama++;
        persenGajiLingkaran.textContent = `${persenStartLingkaranPertama}%`;
        tigaLingkaranPertama.style.background = `conic-gradient(#999999 ${persenStartLingkaranPertama * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranPertama === persenEndLingkaranPertama) {
            clearInterval(intervalLingkaranPertama);
        }
    }, speedLingkaranPertama);


    const tigaLingkaranKedua = document.querySelector(".tiga-lingkaran-kedua"),
          persenInvestasiLingkaran = document.querySelector(".persen-investasi-lingkaran");

    let persenStartLingkaranKedua = 0,
        persenEndLingkaranKedua = 30,
        speedLingkaranKedua = 20;

    let intervalLingkaranKedua = setInterval(() => {
        persenStartLingkaranKedua++;
        persenInvestasiLingkaran.textContent = `${persenStartLingkaranKedua}%`;
        tigaLingkaranKedua.style.background = `conic-gradient(#999999 ${persenStartLingkaranKedua * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranKedua === persenEndLingkaranKedua) {
            clearInterval(intervalLingkaranKedua);
        }
    }, speedLingkaranKedua);

    const tigaLingkaranKetiga = document.querySelector(".tiga-lingkaran-ketiga"),
          persenHadiahLingkaran = document.querySelector(".persen-hadiah-lingkaran");

    let persenStartLingkaranKetiga = 0,
        persenEndLingkaranKetiga = 5,
        speedLingkaranKetiga = 20;

    let intervalLingkaranKetiga = setInterval(() => {
        persenStartLingkaranKetiga++;
        persenHadiahLingkaran.textContent = `${persenStartLingkaranKetiga}%`;
        tigaLingkaranKetiga.style.background = `conic-gradient(#999999 ${persenStartLingkaranKetiga * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranKetiga === persenEndLingkaranKetiga) {
            clearInterval(intervalLingkaranKetiga);
        }
    }, speedLingkaranKetiga);


    const tigaLingkaranPertamaKedua = document.querySelector(".tiga-lingkaran-pertama-kedua"),
          persenMakanLingkaran = document.querySelector(".persen-makan-lingkaran");

    let persenStartLingkaranPertamaKedua = 0,
        persenEndLingkaranPertamaKedua = 50,
        speedLingkaranPertamaKedua = 20;

    let intervalLingkaranPertamaKedua = setInterval(() => {
        persenStartLingkaranPertamaKedua++;
        persenMakanLingkaran.textContent = `${persenStartLingkaranPertamaKedua}%`;
        tigaLingkaranPertamaKedua.style.background = `conic-gradient(#999999 ${persenStartLingkaranPertamaKedua * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranPertamaKedua === persenEndLingkaranPertamaKedua) {
            clearInterval(intervalLingkaranPertamaKedua);
        }
    }, speedLingkaranPertamaKedua);

    const tigaLingkaranKeduaKedua = document.querySelector(".tiga-lingkaran-kedua-kedua"),
          persenPajakLingkaran = document.querySelector(".persen-pajak-lingkaran");

    let persenStartLingkaranKeduaKedua = 0,
        persenEndLingkaranKeduaKedua = 15,
        speedLingkaranKeduaKedua = 20;

    let intervalLingkaranKeduaKedua = setInterval(() => {
        persenStartLingkaranKeduaKedua++;
        persenPajakLingkaran.textContent = `${persenStartLingkaranKeduaKedua}%`;
        tigaLingkaranKeduaKedua.style.background = `conic-gradient(#999999 ${persenStartLingkaranKeduaKedua * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranKeduaKedua === persenEndLingkaranKeduaKedua) {
            clearInterval(intervalLingkaranKeduaKedua);
        }
    }, speedLingkaranKeduaKedua);

    const tigaLingkaranKetigaKetiga = document.querySelector(".tiga-lingkaran-ketiga-ketiga"),
          persenRokokLingkaran = document.querySelector(".persen-rokok-lingkaran");

    let persenStartLingkaranKetigaKetiga = 0,
        persenEndLingkaranKetigaKetiga = 35,
        speedLingkaranKetigaKetiga = 20;

    let intervalLingkaranKetigaKetiga = setInterval(() => {
        persenStartLingkaranKetigaKetiga++;
        persenRokokLingkaran.textContent = `${persenStartLingkaranKetigaKetiga}%`;
        tigaLingkaranKetigaKetiga.style.background = `conic-gradient(#999999 ${persenStartLingkaranKetigaKetiga * 3.6}deg, #ededed 0deg)`;

        if (persenStartLingkaranKetigaKetiga === persenEndLingkaranKetigaKetiga) {
            clearInterval(intervalLingkaranKetigaKetiga);
        }
    }, speedLingkaranKetigaKetiga);
    
});
