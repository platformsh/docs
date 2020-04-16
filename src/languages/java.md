# Java

Java is a general-purpose programming language, and one of the most popular in the world today. Platform.sh supports Java runtimes that can be used with build management tools such as Gradle, Maven, and Ant.

## Supported versions

### OpenJDK versions:

* 8
* 11
* 12
* 13

To specify a Java container, use the `type` property in your `.platform.app.yaml`.

{% codesnippet "/registry/images/examples/full/java.app.yaml", language="yaml" %}{% endcodesnippet %}

## Support libraries

While it is possible to read the environment directly from your application, it is generally easier and more robust to use the [`platformsh/config-reader`](https://github.com/platformsh/config-reader-java) which handles decoding of service credential information for you.

## Support build automation

Platform.sh supports the most common project management tools in the Java ecosystem, including:

* [Gradle](https://gradle.org/)
* [Maven](https://maven.apache.org/)
* [Ant](https://ant.apache.org/)

## Accessing services

To access various [services](/configuration/services.md) with Java, see the following examples.  The individual service pages have more information on configuring each service.

{% codetabs name="Elasticsearch", type="java", url="https://examples.docs.platform.sh/java/elasticsearch" -%}

{%- language name="Kafka", type="java", url="https://examples.docs.platform.sh/java/kafka" -%}

{%- language name="Memcached", type="java", url="https://examples.docs.platform.sh/java/memcached" -%}

{%- language name="MongoDB", type="java", url="https://examples.docs.platform.sh/java/mongodb" -%}

{% language name="MySQL", type="java", url="https://examples.docs.platform.sh/java/mysql" -%}

{% language name="PostgreSQL", type="java", url="https://examples.docs.platform.sh/java/postgresql" -%}

{%- language name="RabbitMQ", type="java", url="https://examples.docs.platform.sh/java/rabbitmq" -%}

{% language name="Redis", type="java", url="https://examples.docs.platform.sh/java/redis" -%}

{%- language name="Solr", type="java", url="https://examples.docs.platform.sh/java/solr" -%}

{%- endcodetabs %}

## Project templates

A number of project templates for major Java applications are available on GitHub. Not all of them are proactively maintained but all can be used as a starting point or reference for building your own website or web application.

### Applications

#### Spring

* [Spring Boot MySQL](https://github.com/platformsh-templates/spring-boot-maven-mysql)
* [Spring Boot MongoDB](https://github.com/platformsh-templates/spring-mvc-maven-mongodb)
* [Spring Kotlin](https://github.com/platformsh-templates/spring-kotlin)
* [Spring Boot Gradle](https://github.com/platformsh-templates/spring-boot-gradle-mysql)

#### Jakarta EE/ Eclipse MicroProfile

* [Apache Tomee](https://github.com/platformsh-templates/microprofile-tomee)
* [Thorntail](https://github.com/platformsh-templates/microprofile-thorntail)
* [Payara Micro](https://github.com/platformsh-templates/microprofile-payara)
* [KumuluzEE](https://github.com/platformsh-templates/microprofile-kumuluzee)
* [Helidon](https://github.com/platformsh-templates/microprofile-helidon)
* [Open Liberty](https://github.com/platformsh-templates/microprofile-openliberty)

## Other Frameworks

* [Micronaut](https://github.com/platformsh-templates/micronaut)
* [Jettry](https://github.com/platformsh-templates/jetty)
* [Jenkins](https://github.com/platformsh-templates/jenkins)
* [Xwiki](https://github.com/platformsh-templates/xwiki)
