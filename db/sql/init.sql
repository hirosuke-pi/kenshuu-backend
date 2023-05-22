CREATE TABLE "users" (
  "id" integer PRIMARY KEY,
  "username" varchar NOT NULL,
  "email" varchar UNIQUE NOT NULL,
  "password" varchar NOT NULL,
  "profile_img_path" varchar NOT NULL,
  "created_at" timestamp NOT NULL DEFAULT (now()),
  "deleted_at" timestamp
);

CREATE TABLE "posts" (
  "id" integer PRIMARY KEY,
  "user_id" integer NOT NULL,
  "title" varchar NOT NULL,
  "body" text NOT NULL,
  "created_at" timestamp NOT NULL DEFAULT (now()),
  "updated_at" timestamp,
  "deleted_at" timestamp
);

CREATE TABLE "images" (
  "id" integer PRIMARY KEY,
  "post_id" integer NOT NULL,
  "thumbnail_flag" bool NOT NULL DEFAULT false,
  "file_path" varchar NOT NULL
);

CREATE TABLE "posts_tags" (
  "post_id" integer,
  "tag_id" integer,
  PRIMARY KEY ("post_id", "tag_id")
);

CREATE TABLE "tags" (
  "id" integer PRIMARY KEY,
  "tag_name" varchar UNIQUE NOT NULL
);

COMMENT ON TABLE "users" IS 'ユーザー';

COMMENT ON COLUMN "users"."id" IS 'ユーザーID';

COMMENT ON COLUMN "users"."username" IS 'ユーザー名';

COMMENT ON COLUMN "users"."email" IS 'メールアドレス';

COMMENT ON COLUMN "users"."password" IS 'パスワード';

COMMENT ON COLUMN "users"."profile_img_path" IS 'プロフィール画像ファイルパス';

COMMENT ON COLUMN "users"."created_at" IS 'ユーザー作成日時';

COMMENT ON COLUMN "users"."deleted_at" IS 'ユーザー削除日時';

COMMENT ON TABLE "posts" IS '記事';

COMMENT ON COLUMN "posts"."id" IS '記事ID';

COMMENT ON COLUMN "posts"."user_id" IS 'ユーザーID';

COMMENT ON COLUMN "posts"."title" IS 'タイトル';

COMMENT ON COLUMN "posts"."body" IS '本文';

COMMENT ON COLUMN "posts"."created_at" IS '記事作成日時';

COMMENT ON COLUMN "posts"."updated_at" IS '記事更新日時';

COMMENT ON COLUMN "posts"."deleted_at" IS '記事削除日時';

COMMENT ON TABLE "images" IS '画像';

COMMENT ON COLUMN "images"."id" IS '画像ID';

COMMENT ON COLUMN "images"."post_id" IS '記事ID';

COMMENT ON COLUMN "images"."thumbnail_flag" IS '記事ID';

COMMENT ON COLUMN "images"."file_path" IS '画像ファイルパス';

COMMENT ON TABLE "posts_tags" IS '記事・タグリレーション';

COMMENT ON COLUMN "posts_tags"."post_id" IS '記事ID';

COMMENT ON COLUMN "posts_tags"."tag_id" IS 'タグID';

COMMENT ON TABLE "tags" IS 'タグ';

COMMENT ON COLUMN "tags"."id" IS 'タグID';

COMMENT ON COLUMN "tags"."tag_name" IS 'タグ名';

ALTER TABLE "posts" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "images" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");

ALTER TABLE "posts_tags" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");

ALTER TABLE "posts_tags" ADD FOREIGN KEY ("tag_id") REFERENCES "tags" ("id");
