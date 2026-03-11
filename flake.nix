{
  description = "cohete-ddd - DDD Value Objects library (PHP 8.2)";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
  };

  outputs = { self, nixpkgs }:
    let
      supportedSystems = [ "x86_64-linux" "aarch64-darwin" ];
      forAllSystems = nixpkgs.lib.genAttrs supportedSystems;

      pkgsFor = system: import nixpkgs { inherit system; };

      phpFor = system:
        let pkgs = pkgsFor system;
        in pkgs.php82.buildEnv {
          extensions = { enabled, all }: enabled ++ (with all; [
            mbstring
            intl
          ]);
          extraConfig = ''
            memory_limit = 512M
          '';
        };
    in
    {
      devShells = forAllSystems (system:
        let
          pkgs = pkgsFor system;
          php = phpFor system;
        in
        {
          default = pkgs.mkShell {
            buildInputs = [
              php
              php.packages.composer
            ];

            shellHook = ''
              echo "cohete-ddd dev environment"
              echo "  PHP:      $(php -v | head -1)"
              echo "  Composer: $(composer --version 2>/dev/null | head -1)"
              echo ""
              echo "Commands:"
              echo "  composer install              Install dependencies"
              echo "  vendor/bin/phpunit            Run tests"
              echo "  vendor/bin/phpstan analyse    Run static analysis"
            '';
          };
        });

      checks = forAllSystems (system:
        let
          pkgs = pkgsFor system;
          php = phpFor system;
        in
        {
          default = pkgs.runCommand "cohete-ddd-checks" {
            nativeBuildInputs = [ php php.packages.composer ];
            src = self;
          } ''
            cp -r $src/* .
            export COMPOSER_HOME=$(mktemp -d)
            export HOME=$(mktemp -d)
            composer install --no-interaction --no-progress
            vendor/bin/phpunit
            vendor/bin/phpstan analyse
            touch $out
          '';
        });
    };
}
