# モダンなWordPress template

bedrock をフォークしてカスタマイズしたものです。[bedrockはこちら](https://github.com/roots/bedrock)
bedrockとは通常のwordpressではセキュリティで欠陥がある個所を補ったものです。またcomposerを使ってプラグインを管理できる構成になっています。

## 環境構築手順

1. brewをinstall
   [Brewのinstall](https://brew.sh/ja/)
2. Docker Desktopをinstall
   [Docker Desktop](https://brew.sh/ja/)

Windowsの場合にはscoopを使用
[scoopのinstall](https://docs.docker.com/desktop/install/windows-install/)

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

## デプロイ同期（DBマイグレーション＋固定ページ）

`deploy/pages.json` を正として、デプロイ後に WP-CLI で DB の状態をコードに揃える仕組みがあります。

- 固定ページの作成・更新・削除（ゴミ箱）は `bin/sync-pages.php` が `deploy/pages.json` の定義から行います。手動作成のページは消えません。
- DBマイグレーションは `deploy/migrations/NNNN_名前.php` を `bin/run-migrations.php` が未適用分だけ実行します。
- まとめて実行するには `bash bin/deploy-sync.sh`。GitHub Actions の `deploy.yml` は `vars.WP_DEPLOY_ENABLED=true` の時だけ走ります。
- 詳細は `deploy/README.md` を参照してください。

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
