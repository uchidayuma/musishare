function confirmCheck(message) {
    //ret変数に確認ダイアログの結果を代入する。
    answer = confirm(message);
    //確認ダイアログの結果がNoなら処理を止める
    if (answer == false) {
        return false;
    }
}