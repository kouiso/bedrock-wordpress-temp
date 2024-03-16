
# モダンなWordPress template

bedrock をフォークしてカスタマイズしたものです。[bedrockはこちら](https://github.com/roots/bedrock)

## 環境構築手順

1. brewをinstall
[Brewのinstall](https://brew.sh/ja/)

Windowsの場合にはscoopを使用
[scoopのinstall](https://scoop.sh/)

2. voltaを設定する

```bash
brew install volta go-task
```

Windowsの場合

```bash
scoop bucket add main
scoop install main/volta
scoop install go-task
```

### clone後の環境構築手順

一度設定が終わればcloneした時にはここから始めれば良いはずです。

1. .envの編集
`.env.development.example` をコピーして `.env.development` を作成してください。

1. プロジェクトのルートディレクトリで、以下のコマンドを実行して依存関係をインストールします。

```bash
yarn install
```

```bash
composer install
```

### コンパイル方法

tsとscssをコンパイルするときはgulpを使用しています。
以下を実行するとファイルの変更を読み取って自動コンパイルが走ります。

```bash
yarn watch
```

### 実行方法

1. プロジェクトが正しくセットアップされたら、以下のコマンドで開発サーバーを起動します。
gotaskとdockerを使用することで、wordpressを立ち上げています。

```bash
task up
```

2. ブラウザを開き `http://localhost:3000` にアクセスして、プロジェクトが正しく表示されることを確認します。

## エラーで困ったときは？

以下のコマンドを実行するとこのプロジェクトに関するdockerのリソースのみが削除され、再構築されます。※データは消えてなくなります。

```bash
task init 
```
