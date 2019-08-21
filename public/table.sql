# 작성자 id  칼럼이 추가된 joke  테이블
CREATE TABLE `joke` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `joketext` TEXT,
  `jokedate` DATE NOT NULL,
  `authorid` INT
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

# 작성자 테이블
CREATE TABLE `author` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255),
  `email` VARCHAR(255)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

# 작성자 정보 삽입
INSERT INTO `author` SET `id`=1, `name`='Kevin Yank', `email`='thatguy@kevinyank.com';
INSERT INTO `author` SET `id`=2, `name`='Tom Butler', `email`='tom@r.je';

# 유머글 삽입
INSERT INTO `joke` SET `joketext`='How many programmers does it take to screw in a lightbulb?',`jokedate`='2017-04-01',`authorid`=1;
INSERT INTO `joke` SET `joketext`='why did the programmer quit his job? he didn\t gets arrays',`jokedate`='2017-04-01',`authorid`=1;
INSERT INTO `joke` SET `joketext`='why was the empty array stuck outsides? It didn\t have any keys',`jokedate`='2017-04-01',`authorid`=2;