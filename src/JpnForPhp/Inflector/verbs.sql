CREATE TABLE IF NOT EXISTS verbs (
  id    INTEGER PRIMARY KEY     NOT NULL,
  kanji TEXT,
  kana  TEXT                    NOT NULL,
  type  TEXT                    NOT NULL
);
CREATE INDEX verbs_kanji_idx ON verbs (kanji);
CREATE INDEX verbs_kana_idx ON verbs (kana);
