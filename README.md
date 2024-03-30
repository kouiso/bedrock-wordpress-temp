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

※node.jsやyarnをvolta以外の方法で既に管理している場合は、voltaで管理しているnode.jsのパスが優先されるように設定をお願いします。

ディレクトリごとにパスを切り替えられるものもあります。
[direnv](https://devops-blog.virtualtech.jp/entry/20230404/1680576371)

### clone後の環境構築手順

一度設定が終わればcloneした時にはここから始めれば良いはずです。

1. .envの編集
   `.env.development.example` をコピーして `.env.development` を作成してください。

### 実行方法

1. プロジェクトが正しくセットアップされたら、以下のコマンドで開発サーバーを起動します。
   gotaskとdockerを使用することで、wordpressを立ち上げています。

```bash
task up
```

2. 既存のdockerリソースを破棄し、再構築。その後にwordpressとgulpのタスクランナーを起動

```bash
task reup
```

3. ブラウザを開き `http://localhost:3000` にアクセスして、プロジェクトが正しく表示されることを確認します。

## エラーで困ったときは？

以下のコマンドを実行するとこのプロジェクトに関するdockerのリソースのみが削除され、再構築されます。
※データは消えてなくなります。

```bash
task init
```

or

```bash
task reup
```

も有効です。
